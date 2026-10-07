-- =========================================================
-- Fix: Drop old BIGINT users table and recreate with UUID
-- Paste and run this in Supabase Dashboard -> SQL Editor
-- =========================================================

-- 1. Drop existing tables to fix the id type mismatch
DROP TABLE IF EXISTS public.tasks CASCADE;
DROP TABLE IF EXISTS public.users CASCADE;

-- 2. Recreate public.users using UUID (matching Supabase auth.users)
CREATE TABLE public.users (
    id UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. Recreate public.tasks referencing UUID user_id
CREATE TABLE public.tasks (
    id BIGSERIAL PRIMARY KEY,
    user_id UUID REFERENCES public.users(id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. Trigger function to auto-sync new signups into public.users
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO public.users (id, name, email, created_at, updated_at)
    VALUES (
        NEW.id,
        COALESCE(NEW.raw_user_meta_data->>'name', split_part(NEW.email, '@', 1)),
        NEW.email,
        NOW(),
        NOW()
    )
    ON CONFLICT (id) DO UPDATE
    SET name = EXCLUDED.name,
        email = EXCLUDED.email,
        updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- 5. Attach trigger to auth.users
DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;
CREATE TRIGGER on_auth_user_created
    AFTER INSERT ON auth.users
    FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();

-- 6. Sync existing user(s) from auth.users into public.users
INSERT INTO public.users (id, name, email, created_at, updated_at)
SELECT 
    id, 
    COALESCE(raw_user_meta_data->>'name', split_part(email, '@', 1)), 
    email, 
    created_at, 
    updated_at 
FROM auth.users
ON CONFLICT (id) DO NOTHING;
