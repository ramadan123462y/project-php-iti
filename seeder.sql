-- ROOMS
INSERT INTO rooms (room_number, name) VALUES
(101,'Room 101'),
(102,'Room 102'),
(103,'Room 103'),
(104,'Room 104'),
(105,'Room 105');



-- CATEGORIES
INSERT INTO product_category (name) VALUES
('Hot Drinks'),
('Cold Drinks'),
('Snacks'),
('Desserts');



-- PRODUCTS (image fixed = Tea.jpg)
INSERT INTO products (name, price, image, category_id, is_available) VALUES
('Tea',10,'Tea.jpg',1,1),
('Coffee',15,'Tea.jpg',1,1),
('Nescafe',20,'Tea.jpg',1,1),
('Cappuccino',25,'Tea.jpg',1,1),

('Pepsi',12,'Tea.jpg',2,1),
('7UP',12,'Tea.jpg',2,1),
('Orange Juice',18,'Tea.jpg',2,1),

('Chips',10,'Tea.jpg',3,1),
('Biscuits',8,'Tea.jpg',3,1),
('Chocolate',12,'Tea.jpg',3,1),

('Donut',20,'Tea.jpg',4,1),
('Cake',35,'Tea.jpg',4,1),
('Ice Cream',25,'Tea.jpg',4,1);



-- USERS (password plain text, image fixed = default.jpg)
INSERT INTO users (name,email,password,room_id,ext,role,image) VALUES
('Admin','admin@cafeteria.com','123456',1,'101','admin','default.jpg'),
('Ahmed Mohamed','ahmed@cafeteria.com','123456',2,'102','user','default.jpg'),
('Sara Ali','sara@cafeteria.com','123456',3,'103','user','default.jpg'),
('Omar Khaled','omar@cafeteria.com','123456',4,'104','user','default.jpg'),
('Mona Hassan','mona@cafeteria.com','123456',5,'105','user','default.jpg');



-- ORDERS
INSERT INTO orders (user_id, room_id, notes, status, total_price) VALUES
(2,2,'No sugar','pending',35),
(3,3,'','processing',30),
(4,4,'Extra hot','completed',45),
(5,5,'','pending',38);



-- ORDER ITEMS
INSERT INTO order_item (order_id, product_id, quantity, price) VALUES

(1,1,1,10),
(1,2,1,15),
(1,8,1,10),

(2,4,1,25),
(2,9,1,5),

(3,4,1,25),
(3,8,2,10),

(4,3,1,20),
(4,7,1,18);