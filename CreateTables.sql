CREATE TABLE userPassword (
userName CHAR(20)
password INTEGER,
PRIMARY KEY(userName))

CREATE TABLE userName (
userID INTEGER,
userName CHAR(20),
PRIMARY KEY(userID))

CREATE TABLE recipeName(
recipeID INTEGER,
recipeName CHAR(20),
PRIMARY KEY (recipe ID))

CREATE TABLE difficulty(
preparationTime INTEGER,
difficulty, INTEGER,
PRIMARY KEY(preparationTime))

CREATE TABLE preparationTime (
recipeName CHAR(20),
preparationTime INTEGER,
PRIMARY KEY(recipeName))

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

CREATE TABLE Ingredient (
ingredientID INTEGER, 
ingredientName CHAR(20), 
amount INTEGER, 
unit CHAR(20),
PRIMARY KEY (ingredientID))

CREATE TABLE Author ( 
authorID INTEGER,
authorName CHAR(20),
PRIMARY KEY (authorID))

CREATE TABLE Has ( 
recipeID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (recipeID, ingredientID),	
FOREIGN KEY (userID) REFERENCES User,
FOREIGN KEY (recipeID) REFERENCES Recipe)

CREATE TABLE Has ( 
userID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (userID, ingredientID),
FOREIGN KEY (userID) REFERENCES User,
FOREIGN KEY (ingredientID) REFERENCES Ingredient)

CREATE TABLE Requires ( 
recipeID INTEGER,
toolID INTEGER,
PRIMARY KEY (recipeID, toolID),
FOREIGN KEY (toolID) REFERENCES Tool,
FOREIGN KEY (recipeID) REFERENCES Recipe)

CREATE TABLE Requires ( 
recipeID INTEGER,
ingredientID INTEGER,
PRIMARY KEY (recipeID, ingredientID),
FOREIGN KEY (ingredientID) REFERENCES Ingredient,
FOREIGN KEY (recipeID) REFERENCES Recipe)
