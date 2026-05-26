Markdown
# 📰 NewsRoom API backend



---

## 🚀 1. How to Setup and Run the Project (setup steps)

Follow these steps to get the development environment running locally:

### Prerequisites
* PHP >= 8.2
* Composer
* MySQL Database (XAMPP / Laragon / Native)


TO RUN THE PROJECT

1   php artisan serve

2   php artisan migrate --seed

3   php artisan queue:work --queue=high,default,low




🏗️ 3. Architectural Decisions & Rationales

### D. Repository Pattern & Interface-Driven Design
Interfaces:
  1. `ArticleRepositoryInterface` ➡️ Declares the architectural contract for CRUD and archiving actions on the `Article` model.
  2. `UserRepositoryInterface` ➡️ Handles user-specific queries, role checks, and database aggregation for reporting.
  3. `NotificationDispatcherInterface` ➡️ Abstracts out the mailing/notification subsystem (e.g., system alerts, reports, or registration greetings).



ArticleRepository ➡️ Implements ArticleRepositoryInterface to handle Fluent/Eloquent database interactions for content and archiving.

UserRepository ➡️ Implements UserRepositoryInterface to encapsulate user roles, profiles, and data aggregation logic.

ArticlePublishedDbNotification ➡️ Implements NotificationDispatcherInterface to process and store  notifications .

ArticlePublishedMailNotification ➡️ Implements NotificationDispatcherInterface to manage email delivery payloads and queue dispatching for published content.


### CONTROLLER 

"In the controller layer, API versioning was implemented to seamlessly introduce new features without disrupting existing endpoints. Furthermore, each controller method injects its corresponding service layer component to delegate and handle all core business logic."

###  Authorization using Laravel Policies
using Laravel Policies (`ArticlePolicy`):
  1. `create` ➡️ Restricts content creation privileges strictly to users with the `writer` role.
  2. `view` / `update` ➡️ Enforces strict resource ownership, ensuring a `writer` can only view or modify their own articles, while granting global view overrides to the `admin`.
  3. `delete` ➡️ Grants deletion capabilities to the resource owner (`writer`) as well as the system `admin`.

### Laravel Task Scheduling

SendWeeklyArticlesReport (Job) ➡️ Dispatches an asynchronous compilation of weekly performance metrics every Sunday at midnight (->weeklyOn(0, '00:00')).

CacheMostUsedTagsJob (Job) ➡️ Executes an efficient data aggregation task every hour to keep highly requested content tags freshly warm in Redis (->hourly()).

articles:archive (Artisan Command) ➡️ Triggers structural cleanup of unreleased draft payloads automatically at the start of every month (->monthly()).

articles:report (Artisan Command) ➡️ Generates a comprehensive analytical log report of writer statistics every Friday morning at 8:00 AM (->weeklyOn(5, '08:00')).




📊 2. Entities and Relationships (ERD Concepts)


User ➡️ Serves as the central entity, establishing a One-to-One relationship with Profile (hasOne), and structured One-to-Many relationships with both Article and standard Comment collections (hasMany).

Article ➡️ Relies on a standard inversion (belongsTo) back to its author (User). It expands into polymorphic domain space via a specialized Polymorphic One-to-One relation with Attachment (morphOne), a Polymorphic One-to-Many relation with Comment (morphMany), and a Polymorphic Many-to-Many setup with Tag (morphToMany).

Comment ➡️ References its writer directly via a User foreign key boundary (belongsTo), while utilizing a Polymorphic morphTo target (commentable) to seamlessly allow users to drop comments onto articles or potentially other system resources.

Profile & Tag ➡️ Profile stores granular user meta-data bound to a parent account (belongsTo) while supporting its own unique polymorphic Attachment field. Tag functions as a decoupled entity mapping backward to parent content blocks via its Polymorphic Many-to-Many pivot engine (morphedByMany).


### K. Dynamic Content Read-Time Estimation via Eloquent Accessors
* **What was done:** Implemented an on-the-fly computational logic using Laravel's Eloquent Accessors (`reading_time`) to dynamically measure the estimated reading time of an article before generating the API payload.
  
