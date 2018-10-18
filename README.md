# Introduction
 A login module that is focused on code quality, done in the course 1dv610 by Filip Gal.

1. General information
2. Observations
3. Use cases
4. Reflection

#   1. General information
 
##  1.1 How to install
- Clone the repo
- Open the solution, add a config folder, and add a file called `Config.php`
- Create a class with the following structure:

```php
<?php

namespace Config;

class Config
{
    private $host = 'your host';
    private $user = 'your user';
    private $pass = 'your password';
    private $name = 'your name';

    public function dbHost()
    {
        return $this->host;
    }

    public function dbUser()
    {
        return $this->user;
    }

    public function dbPass()
    {
        return $this->pass;
    }

    public function dbName()
    {
        return $this->name;
    }
}
```

You also need to add two tables to your database, these tables should be named `Users` and `posts` (notice the difference in uppercase). You can do this manually in your mysql database or by running the CLI commands:

Create user table:
```sql
CREATE TABLE `Users` (
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

Create post table:
```sql
CREATE TABLE `posts` (
  `post` VARCHAR(75) NOT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT
  `author` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

 #  2. Observations
During the period that I have been working on the login module, a lot has changed. Initially, there was no focus on the quality of the code, other than to make stuff work, things that needed to be working were things such as:
- Register new users
- Log in with existing users
- Validate user credentials and give appropriate feedback.

 ## 2.1 Changes
My code has seen many changes during the period of the course. Some notable examples:
- Dependency injection

Initially I instantiated new objects wherever they were needed, for instance, the SessionModel had new instances in both the RegisterModel and LoginModel. This was later refactored in favor of dependency injection, making so that I only had to instantiate these objects once. It quickly led to a very bloated MainController that took 7-8 arguments.

The dependency injection madness in the main controller was somewhat remedied by adding a combined authentication controller, the same ammount of injected objects remain the same, but is abstracted away from the main controller.

 ## 2.2 Status
 Things that are not implemented from the test cases are the following

 - Login by cookies
 - Failed login by too old cookies
 - Failed login by manipulated cookies
 - Protection from session hijacking
 - Validation message for newly registered users
 - UC2
 - UC3

 #  3. Additional Requirements

 I will attempt to add some simple CRUD functionality where users can post, as well as read other users posts. These posts should only be able to be edited and/or deleted by the author of the post.

 ## 3.1 Additional Requirements - Use cases

 ### UC1 Submit post
1. Starts when a user is authenticated and logged in
2. System presents user with the logged in screen together with the option to submit posts
3. User enters her post and clicks submit
4. System handles the request and submits the post

#### Alternate scenarios
4. i. The post is too long and an error is returned 

 ### UC2 Edit post
1. Starts when a user is authenticated and logged in
2. System presents user with the logged in screen together with the option to submit posts
3. User navigates to a post she has made and clicks the edit button
4. System presents the user with another input box where the user can enter a new text
5. User enters the new text and clicks "Save"
6. System updates the text and rerenders it accordingly.

#### Alternate scenarios
6. i. The post is too long and an error is returned 

 ### UC3 Delete post
1. Starts when a user is authenticated and logged in
2. System presents user with the logged in screen together with the option to submit posts
3. User navigates to a post she has made and clicks the delete button
4. System handles the request and deletes the post

### UC4 View post
1. Starts when a user is authenticated and logged in
2. System presents user with the logged in screen together with all the posts that have been made

#   4. Reflection
I think I have done a fairly good job in fulfilling much of the examination criteria for this assignment. There are however some requirements I feel like I have not implemented, the most prominent being the `Errors are handled well (Validation, Exceptions)` criteria. The only exception I handle is if a users post is too long in UC1, also, this isn't presented to the user. If I had more time I would improve this exception and how it's handled, I would also add more error handling during the registration of a new user, as well as logging in with a registered user.

Another thing that I would've tried to implement, given more time, would be a specific class for a user, like the `Comments` class, where I could more easily create exceptions for all types of errors that can occur.

I still don't like the dependency injection madness that occurs in `Index.php`, I was thinking about implementing a factory to handle these injections, but it would still result in the same code, and it would still be incredibly arduous to test.

One key takeaway that I have is that it feels like you can always refactor more, but it is important to know when to stop. I spent a good week just refactoring, before I forced myself to let it go and instead start implementing the extra use cases. I feel like the login- & register model could be improved a lot as it feels like there some code that is not directly duplicated there, but that could be refactored in a way that made it fit both use cases.