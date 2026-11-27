BEGIN;
INSERT INTO games (title, image_url, platform, genre, release_year, status, rating) VALUES
    ('Cyberpunk 2077', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1091500/library_600x900.jpg', 'PC', 'RPG', 2020, 'Speelt nu', 4),
    ('Hollow Knight', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/367520/library_600x900.jpg', 'PC', 'Adventure', 2017, 'Uitgespeeld', 5),
    ('The Witcher 3', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/292030/library_600x900.jpg', 'PlayStation', 'RPG', 2015, 'Wishlist', NULL),
    ('Hades', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1145360/library_600x900.jpg', 'Switch', 'Action', 2020, 'Uitgespeeld', 5),
    ('Elden Ring', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/library_600x900.jpg', 'PlayStation', 'RPG', 2022, 'Speelt nu', 5),
    ('Portal 2', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/620/library_600x900.jpg', 'PC', 'Adventure', 2011, 'Uitgespeeld', 5),
    ('DOOM Eternal', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/782330/library_600x900.jpg', 'Xbox', 'Action', 2020, 'In bezit', 4),
    ('Stardew Valley', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/413150/library_600x900.jpg', 'Switch', 'Adventure', 2016, 'Speelt nu', 4),
    ('Sid Meier’s Civilization VI', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/289070/library_600x900.jpg', 'PC', 'Strategy', 2016, 'In bezit', NULL),
    ('Baldur’s Gate 3', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1086940/library_600x900.jpg', 'PC', 'RPG', 2023, 'Wishlist', NULL),
    ('Disco Elysium', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/632470/library_600x900.jpg', 'PC', 'RPG', 2019, 'Wishlist', NULL),
    ('Control', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/870780/library_600x900.jpg', 'PlayStation', 'Action', 2019, 'In bezit', NULL),
    ('Resident Evil 4', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/2050650/library_600x900.jpg', 'PlayStation', 'Action', 2023, 'Wishlist', NULL),
    ('Forza Horizon 5', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1551360/library_600x900.jpg', 'Xbox', 'Sport', 2021, 'In bezit', 4),
    ('Dead Cells', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/588650/library_600x900.jpg', 'Switch', 'Action', 2018, 'Uitgespeeld', 4),
    ('Metro Exodus', 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/412020/library_600x900.jpg', 'PC', 'Action', 2019, 'Uitgespeeld', 4)
ON CONFLICT (title, release_year) DO UPDATE SET image_url = excluded.image_url WHERE games.image_url = '';
COMMIT;
