DROP TABLE User;
DROP TABLE Recipe_1;
DROP TABLE Recipe_2;
DROP TABLE Recipe_3;
DROP TABLE Requires_1;
DROP TABLE Ingredient;
DROP TABLE Has_1;

CREATE TABLE User (
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
FOREIGN KEY (userID) REFERENCES User,
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)






CREATE TABLE Appetizer (
recipeID INTEGER, 
shareability CHAR(20)
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeID) REFERENCES Recipe)

CREATE TABLE MainCourse (
recipeID INTEGER, 
meatType CHAR(20)
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeID) REFERENCES Recipe)

CREATE TABLE Dessert (
recipeID INTEGER, 
dessertFlavour CHAR(20),
PRIMARY KEY (recipeID),
FOREIGN KEY (recipeID) REFERENCES Recipe)

CREATE TABLE Step_Has(
stepID INTEGER, 
stepNumber INTEGER, 
stepDescription CHAR(80),
recipeID INTEGER,
PRIMARY KEY (stepID),
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE NO ACTION
ON UPDATE CASCADE)

CREATE TABLE Tool (
toodID INTEGER,
toolName CHAR(20)
PRIMARY KEY (tooID),
UNIQUE (toolName))

CREATE TABLE Picture_Contains(
pictureID INTEGER, 
pictureTitle CHAR(20),
recipeID INTEGER NOT NULL,
PRIMARY KEY (pictureID, recipeID),
FOREIGN KEY (recipeID) REFERENCES Recipe
ON DELETE CASCADE)

CREATE TABLE Author ( 
authorID INTEGER,
authorName CHAR(20),
PRIMARY KEY (authorID))

CREATE TABLE Has_2 ( 
userID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (userID, ingredientID),
FOREIGN KEY (userID) REFERENCES User,
FOREIGN KEY (ingredientID) REFERENCES Ingredient)

CREATE TABLE Requires_2 ( 
recipeID INTEGER,
toolID INTEGER,
PRIMARY KEY (recipeID, toolID),
FOREIGN KEY (toolID) REFERENCES Tool,
FOREIGN KEY (recipeID) REFERENCES Recipe)


