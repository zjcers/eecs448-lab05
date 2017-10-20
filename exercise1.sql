CREATE TABLE Users (user_id INT NOT NULL AUTO_INCREMENT,
                    PRIMARY KEY(user_id)
);
CREATE TABLE Posts (post_id INT NOT NULL AUTO_INCREMENT,
                    content TEXT,
                    author_id INT NOT NULL,
                    PRIMARY KEY(post_id),
                    FOREIGN KEY(author_id) REFERENCES Users(user_id)
);