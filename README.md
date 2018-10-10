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


