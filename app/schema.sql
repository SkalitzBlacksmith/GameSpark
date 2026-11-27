BEGIN;
CREATE TABLE IF NOT EXISTS games (
    id INTEGER PRIMARY KEY,
    title TEXT NOT NULL COLLATE NOCASE,
    image_url TEXT NOT NULL DEFAULT '',
    platform TEXT NOT NULL,
    genre TEXT NOT NULL DEFAULT '',
    release_year INTEGER NOT NULL CHECK (release_year BETWEEN 1000 AND 9999),
    status TEXT NOT NULL CHECK (status IN ('Wishlist', 'In bezit', 'Speelt nu', 'Uitgespeeld')),
    rating INTEGER CHECK (rating BETWEEN 1 AND 5),
    note TEXT NOT NULL DEFAULT '',
    recommended_by TEXT NOT NULL DEFAULT '',
    UNIQUE (title, release_year)
);
COMMIT;
