-- Drop the table if it already exists
DROP TABLE IF EXISTS products;

-- Create the 'products' table
CREATE TABLE products (
    id INTEGER AUTO_INCREMENT,
    mpn CHAR(250) NOT NULL,
    price REAL NOT NULL DEFAULT 0,
    cost REAL NOT NULL DEFAULT 0,
    stock INTEGER NOT NULL DEFAULT 0,
    PRIMARY KEY(id),
    UNIQUE KEY(mpn)
);

-- Test data
INSERT INTO products (mpn, price, cost, stock) VALUES
('1397-IL-CS', 0, 0, 0),
('1397-IL-EA', 0, 0, 0),
('1395-500', 0, 0, 0),
('1395-CS', 0, 0, 0),
('460031', 0, 0, 0);