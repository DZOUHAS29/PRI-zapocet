CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_name VARCHAR(255) NOT NULL,
    description TEXT,
    prep_time_minutes INT,
    instructions TEXT,
    author_id INT DEFAULT NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ingredient_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS recipe_ingredients (
    menu_id INT NOT NULL,
    ingredient_id INT NOT NULL,
    quantity DECIMAL(10,2),
    unit VARCHAR(50),
    PRIMARY KEY (menu_id, ingredient_id),
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES ingredients(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS recipe_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    menu_id INT NOT NULL,
    user_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (id, email, password) VALUES
(1, 'pepe@example.cz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'marie@example.cz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'honza@example.cz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(4, 'eva@example.cz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(5, 'karel@example.cz', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO menu (id, recipe_name, description, prep_time_minutes, instructions, author_id) VALUES
(1, 'Spaghetti Carbonara', 'Klasické italské těstoviny s vejci, tvrdým sýrem, sušeným vepřovým masem a černým pepřem.', 25, '1. Uvařte špagety v osolené vodě al dente.\n2. Opečte pancettu na pánvi do křupava.\n3. Smíchejte těstoviny s pancettou, rozšlehanými vejci a sýrem mimo oheň.', 1),
(2, 'Kuřecí Tikka Masala', 'Pečené marinované kousky kuřete v bohatě kořeněné, krémové rajčatové kari omáčce.', 45, '1. Nakrájejte kuřecí prsa a marinujte v kari koření.\n2. Opečte maso na pánvi, přidejte smetanu a nechte chvíli povařit.', 2),
(3, 'Hovězí Stroganov', 'Restované kousky hovězího masa podávané v bohaté omáčce se smetanou nebo zakysanou smetanou.', 30, '1. Na pánvi zprudka orestujte na nudličky nakrájené hovězí maso.\n2. Přidejte nakrájené žampiony a duste do měkka.\n3. Vmíchejte zakysanou smetanu a stáhněte z ohně.', NULL),
(4, 'Restovaná zelenina', 'Křupavá směs zeleniny rychle orestovaná ve woku se sójovou omáčkou, česnekem a zázvorem.', 15, '1. Ve woku rozehřejte olej a přidejte na kousky nakrájenou brokolici.\n2. Zakápněte sójovou omáčkou a restujte 5-7 minut na vysokém plameni.', 3),
(5, 'Pizza Margherita', 'Tradiční neapolská pizza s rajčaty San Marzano, sýrem mozzarella, čerstvou bazalkou a extra panenským olivovým olejem.', 90, '1. Rozválejte těsto na pizzu a potřete jej rozmačkanými rajčaty.\n2. Poklaďte plátky mozzarelly a pečte v rozpálené troubě na 250 °C asi 10 minut.', NULL),
(6, 'Klasický salát Caesar', 'Křupavý římský salát s krutony dochucený citronovou šťávou, olivovým olejem, vejcem, worcestrovou omáčkou, česnekem a parmazánem.', 15, '1. Natrhejte římský salát na menší kousky.\n2. Smíchejte s krutony, zálivkou a posypte hoblinkami parmazánu.', 4),
(7, 'Nadýchané lívance', 'Měkké a nadýchané snídaňové lívance pečené na plotně, podávané s javorovým sirupem.', 20, '1. V míse smíchejte mouku a mléko do hladkého těstíčka.\n2. Na pánvi smažte malé lívanečky z obou stran dozlatova.\n3. Podávejte polité javorovým sirupem.', NULL),
(8, 'Vydatná čočková polévka', 'Teplá a uklidňující polévka z hnědé čočky, mrkve, celeru, cibule a zeleninového vývaru.', 40, '1. Propláchněte čočku a dejte vařit do zeleninového vývaru.\n2. Vařte na mírném ohni do změknutí, dochuťte solí a pepřem.', 5),
(9, 'Tacos al Pastor', 'Autentické mexické tacos z marinovaného vepřového masa grilovaného na rožni, s ananasem, koriandrem a cibulí.', 120, '1. Vepřové maso opečte spolu s kousky ananasu.\n2. Naplňte tortilly připravenou směsí a posypte čerstvými bylinkami.', NULL),
(10, 'Sušenky s kousky čokolády', 'Žvýkací a máslové sušenky plné kousků polosladké čokolády.', 35, '1. Vyšlehejte máslo s cukrem, přidejte mouku a čokoládové kousky.\n2. Tvořte malé hrudky na plech a pečte 12 minut na 180 °C.', 1);

INSERT INTO ingredients (id, ingredient_name) VALUES
(1, 'Špagety'), (2, 'Vejce'), (3, 'Pancetta'), (4, 'Parmazán'), 
(5, 'Kuřecí prsa'), (6, 'Kari koření'), (7, 'Smetana'), 
(8, 'Hovězí svíčková'), (9, 'Žampiony'), (10, 'Zakysaná smetana'),
(11, 'Brokolice'), (12, 'Sójová omáčka'), 
(13, 'Těsto na pizzu'), (14, 'Mozzarella'), (15, 'Rajčata'),
(16, 'Římský salát'), (17, 'Krutony'),
(18, 'Mouka'), (19, 'Mléko'), (20, 'Javorový sirup'),
(21, 'Čočka'), (22, 'Zeleninový vývar'),
(23, 'Vepřové maso'), (24, 'Tortilly'), (25, 'Ananas'),
(26, 'Máslo'), (27, 'Čokoládové kousky'), (28, 'Cukr');

INSERT INTO recipe_ingredients (menu_id, ingredient_id, quantity, unit) VALUES
(1, 1, 400, 'g'), (1, 2, 4, 'ks'), (1, 3, 150, 'g'), (1, 4, 100, 'g'),
(2, 5, 500, 'g'), (2, 6, 2, 'lžíce'), (2, 7, 200, 'ml'),
(3, 8, 400, 'g'), (3, 9, 200, 'g'), (3, 10, 150, 'ml'),
(4, 11, 300, 'g'), (4, 12, 3, 'lžíce'),
(5, 13, 1, 'ks'), (5, 14, 200, 'g'), (5, 15, 150, 'g'),
(6, 16, 1, 'hlávka'), (6, 17, 100, 'g'), (6, 4, 50, 'g'),
(7, 18, 200, 'g'), (7, 19, 250, 'ml'), (7, 20, 50, 'ml'),
(8, 21, 250, 'g'), (8, 22, 1, 'l'),
(9, 23, 500, 'g'), (9, 24, 8, 'ks'), (9, 25, 200, 'g'),
(10, 18, 250, 'g'), (10, 26, 150, 'g'), (10, 27, 200, 'g'), (10, 28, 100, 'g');

INSERT INTO recipe_reviews (menu_id, user_id, rating) VALUES
(1, 2, 5),
(1, 3, 4),
(2, 4, 5),
(5, 5, 3),
(7, 1, 5),
(10, 2, 4);
