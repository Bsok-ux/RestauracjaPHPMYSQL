USE restaurant;

-- Insert 20 categories
INSERT INTO categories (name, description) VALUES
('Appetizers', 'Delicious starters'),
('Soups', 'Warm and hearty soups'),
('Salads', 'Fresh and healthy salads'),
('Main Courses', 'Satisfying main dishes'),
('Desserts', 'Sweet treats to finish your meal'),
('Beverages', 'Hot and cold drinks'),
('Seafood', 'Fresh from the ocean'),
('Pasta', 'Italian pasta dishes'),
('Pizza', 'Authentic Italian pizzas'),
('Grill', 'Grilled meats and vegetables'),
('Vegetarian', 'Delicious vegetarian options'),
('Vegan', 'Plant-based meals'),
('Kids Menu', 'Meals for children'),
('Breakfast', 'Morning specials'),
('Brunch', 'Weekend brunch options'),
('Sides', 'Accompaniments for your main course'),
('Specials', 'Daily and weekly specials'),
('Bakery', 'Freshly baked goods'),
('Wines', 'A selection of fine wines'),
('Beers', 'Local and imported beers');

-- Insert 20 tables
INSERT INTO tables (number, capacity, status) VALUES
(1, 2, 'free'),
(2, 4, 'occupied'),
(3, 4, 'reserved'),
(4, 6, 'free'),
(5, 2, 'free'),
(6, 4, 'occupied'),
(7, 8, 'free'),
(8, 2, 'reserved'),
(9, 4, 'free'),
(10, 6, 'free'),
(11, 2, 'occupied'),
(12, 4, 'free'),
(13, 4, 'reserved'),
(14, 6, 'free'),
(15, 2, 'free'),
(16, 4, 'occupied'),
(17, 8, 'free'),
(18, 2, 'reserved'),
(19, 4, 'free'),
(20, 6, 'free');

-- Insert 20 menu_items
-- Assuming category IDs from 1 to 20 exist from the previous inserts
INSERT INTO menu_items (category_id, name, description, price, is_available) VALUES
(1, 'Spring Rolls', 'Crispy vegetable spring rolls', 6.50, TRUE),
(2, 'Tomato Soup', 'Creamy tomato soup', 5.00, TRUE),
(3, 'Caesar Salad', 'Classic Caesar salad', 8.00, TRUE),
(4, 'Grilled Salmon', 'Salmon fillet with lemon butter sauce', 15.50, TRUE),
(5, 'Chocolate Cake', 'Rich chocolate lava cake', 7.00, TRUE),
(6, 'Iced Tea', 'Freshly brewed iced tea', 3.00, TRUE),
(7, 'Shrimp Scampi', 'Garlic shrimp scampi', 16.00, TRUE),
(8, 'Spaghetti Carbonara', 'Classic Italian carbonara', 12.50, TRUE),
(9, 'Margherita Pizza', 'Tomato, mozzarella, basil', 10.00, TRUE),
(10, 'BBQ Ribs', 'Slow-cooked BBQ ribs', 18.00, TRUE),
(11, 'Vegetable Curry', 'Mixed vegetable curry with rice', 11.50, TRUE),
(12, 'Vegan Burger', 'Plant-based burger with fries', 13.00, TRUE),
(13, 'Chicken Nuggets', 'Kids chicken nuggets with fries', 7.50, TRUE),
(14, 'Pancakes', 'Fluffy pancakes with syrup', 9.00, TRUE),
(15, 'Eggs Benedict', 'Classic eggs benedict', 12.00, TRUE),
(16, 'French Fries', 'Crispy golden french fries', 4.00, TRUE),
(17, 'Steak Special', 'Chef's special steak', 22.00, TRUE),
(18, 'Croissant', 'Buttery croissant', 3.50, TRUE),
(19, 'Red Wine Glass', 'House red wine', 6.00, TRUE),
(20, 'Craft Beer', 'Local craft beer', 5.50, TRUE);

-- Insert 20 orders
-- Assuming table IDs from 1 to 20 exist
INSERT INTO orders (table_id, status, total_amount) VALUES
(1, 'new', 0),
(2, 'in_progress', 0),
(3, 'ready', 0),
(4, 'completed', 0),
(5, 'cancelled', 0),
(6, 'new', 0),
(7, 'in_progress', 0),
(8, 'ready', 0),
(9, 'completed', 0),
(10, 'cancelled', 0),
(11, 'new', 0),
(12, 'in_progress', 0),
(13, 'ready', 0),
(14, 'completed', 0),
(15, 'cancelled', 0),
(16, 'new', 0),
(17, 'in_progress', 0),
(18, 'ready', 0),
(19, 'completed', 0),
(20, 'cancelled', 0);

-- Insert 20 order_items
-- Assuming order IDs and menu_item IDs from 1 to 20 exist.
-- Prices here are per item and should match the menu_items table for consistency if needed for triggers/checks,
-- but for simplicity, I'm using fixed values. Total order amount should be updated accordingly.
INSERT INTO order_items (order_id, menu_item_id, quantity, price) VALUES
(1, 1, 2, 6.50),
(2, 2, 1, 5.00),
(3, 3, 3, 8.00),
(4, 4, 1, 15.50),
(5, 5, 2, 7.00),
(6, 6, 4, 3.00),
(7, 7, 1, 16.00),
(8, 8, 2, 12.50),
(9, 9, 1, 10.00),
(10, 10, 1, 18.00),
(11, 11, 2, 11.50),
(12, 12, 1, 13.00),
(13, 13, 3, 7.50),
(14, 14, 1, 9.00),
(15, 15, 2, 12.00),
(16, 16, 4, 4.00),
(17, 17, 1, 22.00),
(18, 18, 2, 3.50),
(19, 19, 1, 6.00),
(20, 20, 3, 5.50);

-- Note: For orders and order_items, you might need to update the `total_amount` in the `orders` table
-- based on the items and quantities in `order_items`.
-- This can be done manually, through application logic, or database triggers.
-- The sample data for `total_amount` in `orders` is currently 0 and should be updated.
-- For example, for order_id = 1, the total_amount should be 2 * 6.50 = 13.00.
-- For order_id = 2, the total_amount should be 1 * 5.00 = 5.00.
-- And so on. 