DROP TABLE Users;
DROP TABLE Recipe_1;
DROP TABLE Recipe_2;
DROP TABLE Recipe_3;
DROP TABLE Requires_1;
DROP TABLE Ingredient;
DROP TABLE Has_1;

CREATE TABLE Users (
userID CHAR(30),
userName CHAR(20),
password CHAR(20),
PRIMARY KEY(userID),
UNIQUE (userName))

CREATE TABLE Recipe_1(
recipeID CHAR(30),
recipeName CHAR(20),
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeName) REFERENCES Recipe_2
ON DELETE CASCADE)

CREATE TABLE Recipe_2 (
recipeName CHAR(20),
preparationTime INTEGER,
PRIMARY KEY(recipeName),
FOREIGN KEY (preparationTime) REFERENCES Recipe_3
ON DELETE CASCADE)

CREATE TABLE Recipe_3(
preparationTime INTEGER,
difficulty INTEGER,
PRIMARY KEY(preparationTime))

CREATE TABLE Requires_1 ( 
recipeID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (recipeID, ingredientID),
FOREIGN KEY (ingredientID) REFERENCES Ingredient,
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)

CREATE TABLE Ingredient (
ingredientID CHAR(30), 
ingredientName CHAR(20), 
amount INTEGER, 
unit CHAR(20),
PRIMARY KEY (ingredientID))

CREATE TABLE Has_1 (
userID CHAR(30),
recipeID CHAR(30),
PRIMARY KEY (userID, recipeID),
FOREIGN KEY (userID) REFERENCES Users,
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)


INSERT INTO Users VALUES ('user_1', 'xyz', '123456');
INSERT INTO 




