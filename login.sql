CREATE database login_m1s2;
use login_m1s2;
CREATE Table Users(
    Id_user INT AUTO_INCREMENT,
    Username VARCHAR(255),
    Psword VARCHAR(255),
    PRIMARY KEY(Id_user)
);

INSERT INTO Users(Id_user, Username, Psword) VALUES(1,"Schnappi", "Schnappi");
/*
DELETE from Users WHERE Id_user = 1;
DROP table Users;
*/