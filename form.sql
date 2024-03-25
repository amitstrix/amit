CREATE TABLE logins(
    id int,
    fname varchar(255),
    lname varchar(255),
    password varchar(255),
    image varchar(255),
    role varchar (255)
); 


CREATE TABLE logintable(
    id int,
    name varchar(255),
    description varchar(255),
    image varchar(255)
); 

CREATE TABLE order (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        product_name VARCHAR(100) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        message VARCHAR(1500),
        subject VARCHAR(255),
        phone INT(255)
    );