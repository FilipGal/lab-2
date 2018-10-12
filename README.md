# 1dv610 - Code quality
 A login module that is focused on code quality
 ## Observations
During the period that I have been working on the login module, a lot has changed. Initially, there was no focus on the quality of the code, other than to make stuff work, things that needed to be working were things such as:
- Register new users
- Log in with existing users
- Validate user credentials and give appropriate feedback.
 ### Changes
My code has seen many changes during the period of the course. Some notable examples:
- Dependency injection
 Initially I instantiated new objects wherever they were needed, for instance, the SessionModel had new instances in both the RegisterModel and LoginModel. This was later refactored in favor of dependency injection, making so that I only had to instantiate these objects once. It quickly led to a very bloated MainController that took 7-8 arguments.
 
 I am currently in the process of refactoring this.

 ## Status
 Things that are not implemented from the test cases are the following

 - Login by cookies
 - Failed login by too old cookies
 - Failed login by manipulated cookies
 - Protection from session hijacking
 - Validation message for newly registered users

 # Additional Requirements

 I will attempt to add some simple CRUD functionality where users can post, as well as read other users posts. These posts should only be able to be edited and/or deleted by the author of the post.

 ## Additional Requirements - Use cases

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