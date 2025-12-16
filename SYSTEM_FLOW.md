# GUB Alumni Portal - System Working Flow

## 1. Overview

The GUB Alumni Portal is a Laravel-based web application with Vue.js integration for the home page. The system provides different functionalities for three user roles: **Admin**, **Alumni**, and **Student**.

## 2. Technology Stack

- **Backend**: Laravel (PHP Framework)
- **Frontend**: Blade Templates + Vue.js (for Home Page)
- **Database**: MySQL (via Eloquent ORM)
- **Authentication**: Laravel Breeze (Session-based)
- **API**: RESTful API endpoints in `web.php` (under `api/v1` prefix with auth middleware)
- **HTTP Client**: Axios (for Vue.js to Laravel communication)

---

## 3. System Architecture

```mermaid
graph TB
    subgraph "Client Layer"
        Browser[Web Browser]
        VueApp[Vue.js SPA<br/>Home Page]
    end
    
    subgraph "Application Layer"
        WebRoutes[Web Routes<br/>routes/web.php]
        APIEndpoints[API Endpoints<br/>routes/web.php<br/>Prefix: api/v1]
        AuthMiddleware[Authentication<br/>Middleware]
        RoleMiddleware[Role-Based<br/>Middleware]
    end
    
    subgraph "Controller Layer"
        FrontendControllers[Frontend Controllers<br/>Home, Profile, Events, Jobs]
        BackendControllers[Backend Controllers<br/>Admin Dashboard, Posts, Users]
        APIControllers[API Controllers<br/>Posts, Comments, Likes]
    end
    
    subgraph "Business Logic Layer"
        Models[Eloquent Models<br/>User, Post, Event, JobBoard]
        Services[Business Services]
    end
    
    subgraph "Data Layer"
        Database[(MySQL Database)]
        Storage[File Storage<br/>Images, CVs]
    end
    
    Browser --> WebRoutes
    VueApp -->|Axios| APIEndpoints
    WebRoutes --> AuthMiddleware
    APIEndpoints --> AuthMiddleware
    AuthMiddleware --> RoleMiddleware
    RoleMiddleware --> FrontendControllers
    RoleMiddleware --> BackendControllers
    RoleMiddleware --> APIControllers
    FrontendControllers --> Models
    BackendControllers --> Models
    APIControllers --> Models
    Models --> Database
    Models --> Storage
```

---

## 4. User Authentication Flow

```mermaid
sequenceDiagram
    participant User
    participant Browser
    participant Laravel
    participant Middleware
    participant Controller
    participant Database
    
    User->>Browser: Navigate to Portal
    Browser->>Laravel: GET Request
    Laravel->>Middleware: Check Authentication
    
    alt Not Authenticated
        Middleware->>Browser: Redirect to Login
        Browser->>User: Show Login Page
        User->>Browser: Submit Credentials
        Browser->>Laravel: POST /login
        Laravel->>Database: Verify Credentials
        Database-->>Laravel: User Data + Role
        Laravel->>Middleware: Set Session
        Laravel->>Controller: RedirectAuthenticatedUsersController
        Controller->>Browser: Redirect based on Role
    else Authenticated
        Middleware->>Controller: Allow Access
        Controller->>Database: Fetch User Data
        Database-->>Controller: Return Data
        Controller->>Browser: Render View
    end
```

---

## 5. Role-Based Access Control

```mermaid
graph TD
    Start[User Login] --> Auth{Authenticated?}
    Auth -->|No| Login[Login Page]
    Auth -->|Yes| RoleCheck{Check User Role}
    
    RoleCheck -->|Admin| AdminDash[Admin Dashboard<br/>/admin/dashboard]
    RoleCheck -->|Alumni| AlumniDash[Alumni Dashboard<br/>/backend/alumni]
    RoleCheck -->|Student| StudentDash[Student Dashboard<br/>/backend/student]
    
    AdminDash --> AdminFeatures[Admin Features:<br/>- Manage Users<br/>- Manage Posts<br/>- Manage Events<br/>- View Job Applicants<br/>- Manage Job Board]
    
    AlumniDash --> AlumniFeatures[Alumni Features:<br/>- Post Jobs<br/>- View Applicants<br/>- Download CVs<br/>- Manage Job Board]
    
    StudentDash --> StudentFeatures[Student Features:<br/>- View Job Applications<br/>- Apply for Jobs<br/>- View Dashboard]
    
    AdminFeatures --> PublicAccess[Public Access]
    AlumniFeatures --> PublicAccess
    StudentFeatures --> PublicAccess
    
    PublicAccess --> CommonFeatures[Common Features:<br/>- Home Feed<br/>- Profile Management<br/>- View Events<br/>- Alumni List<br/>- Student List<br/>- Job Board]
```

---

## 6. Home Page Request Flow (Vue.js Integration)

### Step 1: User Initiates Request
An authenticated user navigates to the home page and interacts with the Vue.js application.

```mermaid
sequenceDiagram
    participant User
    participant Browser
    participant VueRouter
    participant VueComponent
    participant Axios
    participant LaravelAPI
    participant Database
    
    User->>Browser: Navigate to Home (/)
    Browser->>LaravelAPI: GET / (Initial Page Load)
    LaravelAPI->>Browser: Return Blade Template with Vue App
    Browser->>VueRouter: Initialize Vue Router
    VueRouter->>VueComponent: Load Home.vue Component
    
    Note over VueComponent: Component Mounted
    
    VueComponent->>Axios: GET /api/v1/static-data-for-home-page
    Axios->>LaravelAPI: API Request
    LaravelAPI->>Database: Fetch Posts, Users, Events
    Database-->>LaravelAPI: Return Data
    LaravelAPI-->>Axios: JSON Response
    Axios-->>VueComponent: Update Component State
    VueComponent->>Browser: Render Home Feed
    Browser->>User: Display Home Page
```

### Step 2: Server-Side Processing
The Laravel backend processes the GET request to `/api/v1/static-data-for-home-page`.

```mermaid
graph LR
    A[API Request] --> B[Laravel Router<br/>routes/web.php]
    B --> C[Auth Middleware<br/>Verify Session]
    C --> D[StaticDataForHomePageApiController]
    D --> E[Eloquent Models<br/>Post, User, Event]
    E --> F[MySQL Database<br/>Query Execution]
    F --> G[Eloquent ORM<br/>Data Mapping]
    G --> H[Controller<br/>Format Response]
    H --> I[JSON Response]
    I --> J[Vue Component<br/>Data Binding]
```

### Step 3: Authentication and Authorization
Laravel middleware verifies the user's authentication status and ensures they have the necessary authorization to access their own profile.

```mermaid
graph TD
    Request[Incoming Request] --> AuthCheck{Auth Middleware}
    AuthCheck -->|Not Authenticated| Redirect[Redirect to Login]
    AuthCheck -->|Authenticated| SessionCheck[Verify Session Token]
    SessionCheck --> RoleCheck{Check User Role}
    RoleCheck -->|Valid Role| Controller[Allow Controller Access]
    RoleCheck -->|Invalid Role| Forbidden[403 Forbidden]
    Controller --> Response[Return Response]
```

### Step 4: Data Retrieval
The `StaticDataForHomePageApiController` method interacts with the **Eloquent ORM** to fetch the current profile data from the **MySQL Database**.

```mermaid
sequenceDiagram
    participant Controller
    participant PostModel
    participant UserModel
    participant EventModel
    participant Database
    
    Controller->>PostModel: Post::with('user', 'images', 'likes', 'comments')
    PostModel->>Database: SELECT * FROM posts...
    Database-->>PostModel: Posts Data
    
    Controller->>UserModel: User::all()
    UserModel->>Database: SELECT * FROM users
    Database-->>UserModel: Users Data
    
    Controller->>EventModel: Event::latest()
    EventModel->>Database: SELECT * FROM events...
    Database-->>EventModel: Events Data
    
    PostModel-->>Controller: Posts Collection
    UserModel-->>Controller: Users Collection
    EventModel-->>Controller: Events Collection
    
    Controller->>Controller: Format JSON Response
```

---

## 7. Post Creation Flow (Vue.js to Laravel API)

```mermaid
sequenceDiagram
    participant User
    participant VueComponent
    participant Axios
    participant LaravelRouter
    participant AuthMiddleware
    participant CreatePostApiController
    participant PostModel
    participant ImageModel
    participant Database
    participant Storage
    
    User->>VueComponent: Click "Create Post"
    VueComponent->>User: Show Post Form
    User->>VueComponent: Enter Content + Upload Images
    VueComponent->>Axios: POST /api/v1/posts/store
    Axios->>LaravelRouter: API Request with FormData
    LaravelRouter->>AuthMiddleware: Verify Authentication
    AuthMiddleware->>CreatePostApiController: Allow Access
    
    CreatePostApiController->>CreatePostApiController: Validate Request
    CreatePostApiController->>PostModel: Create New Post
    PostModel->>Database: INSERT INTO posts
    Database-->>PostModel: Post ID
    
    alt Images Uploaded
        CreatePostApiController->>Storage: Store Images
        Storage-->>CreatePostApiController: Image Paths
        CreatePostApiController->>ImageModel: Create Image Records
        ImageModel->>Database: INSERT INTO images
    end
    
    CreatePostApiController-->>Axios: Success Response (201)
    Axios-->>VueComponent: Update State
    VueComponent->>VueComponent: Refresh Feed
    VueComponent->>User: Show Success Message
```

---

## 8. Post Update Flow

```mermaid
sequenceDiagram
    participant User
    participant Browser
    participant LaravelRouter
    participant AuthMiddleware
    participant UpdatePostApiController
    participant PostModel
    participant Database
    
    User->>Browser: Click "Edit Post"
    Browser->>Browser: Show Edit Form (Pre-filled)
    User->>Browser: Modify Content
    User->>Browser: Click "Update"
    Browser->>LaravelRouter: PUT /api/v1/posts/{id}
    LaravelRouter->>AuthMiddleware: Verify Authentication
    AuthMiddleware->>UpdatePostApiController: Allow Access
    
    UpdatePostApiController->>PostModel: Find Post by ID
    PostModel->>Database: SELECT * FROM posts WHERE id = ?
    Database-->>PostModel: Post Data
    
    UpdatePostApiController->>UpdatePostApiController: Check Ownership
    
    alt User is Owner or Admin
        UpdatePostApiController->>PostModel: Update Post
        PostModel->>Database: UPDATE posts SET...
        Database-->>PostModel: Success
        UpdatePostApiController-->>Browser: Success Response (200)
        Browser->>User: Show Success Message
    else Not Authorized
        UpdatePostApiController-->>Browser: 403 Forbidden
        Browser->>User: Show Error Message
    end
```

---

## 9. Like/Unlike Flow

```mermaid
sequenceDiagram
    participant User
    participant VueComponent
    participant Axios
    participant LaravelRouter
    participant LikeController
    participant LikeModel
    participant Database
    
    User->>VueComponent: Click Like Button
    VueComponent->>Axios: POST /api/v1/posts/{post}/like-insert-delete
    Axios->>LaravelRouter: API Request
    LaravelRouter->>LikeController: likeInsertDeleteToPost()
    
    LikeController->>LikeModel: Check if Like Exists
    LikeModel->>Database: SELECT * FROM likes WHERE...
    Database-->>LikeModel: Like Data or Null
    
    alt Like Exists
        LikeController->>LikeModel: Delete Like
        LikeModel->>Database: DELETE FROM likes...
        Database-->>LikeModel: Success
        LikeController-->>Axios: Response: "unliked"
    else Like Doesn't Exist
        LikeController->>LikeModel: Create Like
        LikeModel->>Database: INSERT INTO likes...
        Database-->>LikeModel: Success
        LikeController-->>Axios: Response: "liked"
    end
    
    Axios-->>VueComponent: Update Like Status
    VueComponent->>VueComponent: Toggle Like Icon
    VueComponent->>User: Visual Feedback
```

---

## 10. Comment System Flow

```mermaid
sequenceDiagram
    participant User
    participant VueComponent
    participant Axios
    participant LaravelRouter
    participant PostCommentController
    participant CommentModel
    participant Database
    
    User->>VueComponent: Type Comment
    User->>VueComponent: Click "Post Comment"
    VueComponent->>Axios: POST /api/v1/posts/comments/{postId}
    Axios->>LaravelRouter: API Request
    LaravelRouter->>PostCommentController: store()
    
    PostCommentController->>PostCommentController: Validate Input
    PostCommentController->>CommentModel: Create Comment
    CommentModel->>Database: INSERT INTO comments
    Database-->>CommentModel: Comment ID
    CommentModel-->>PostCommentController: Comment Object
    PostCommentController-->>Axios: Success Response (201)
    Axios-->>VueComponent: New Comment Data
    VueComponent->>VueComponent: Add Comment to List
    VueComponent->>User: Show New Comment
```

---

## 11. Job Application Flow

```mermaid
sequenceDiagram
    participant Student
    participant Browser
    participant LaravelRouter
    participant JobBoardController
    participant JobApplicationDetailModel
    participant JobBoardModel
    participant Database
    participant Storage
    
    Student->>Browser: Browse Jobs
    Browser->>LaravelRouter: GET /jobs
    LaravelRouter->>JobBoardController: index()
    JobBoardController->>JobBoardModel: Get All Active Jobs
    JobBoardModel->>Database: SELECT * FROM job_boards...
    Database-->>JobBoardModel: Jobs Data
    JobBoardModel-->>Browser: Display Jobs List
    
    Student->>Browser: Click "Apply" on Job
    Browser->>LaravelRouter: GET /jobs/{id}/apply
    LaravelRouter->>JobBoardController: applyJobView()
    JobBoardController-->>Browser: Show Application Form
    
    Student->>Browser: Fill Form + Upload CV
    Student->>Browser: Submit Application
    Browser->>LaravelRouter: POST /job/apply
    LaravelRouter->>JobBoardController: applyJob()
    
    JobBoardController->>JobBoardController: Validate Input
    JobBoardController->>Storage: Store CV File
    Storage-->>JobBoardController: CV Path
    
    JobBoardController->>JobApplicationDetailModel: Create Application
    JobApplicationDetailModel->>Database: INSERT INTO job_application_details
    Database-->>JobApplicationDetailModel: Application ID
    
    JobBoardController-->>Browser: Success Response
    Browser->>Student: Show Confirmation Message
```

---

## 12. Admin User Management Flow

```mermaid
sequenceDiagram
    participant Admin
    participant Browser
    participant LaravelRouter
    participant RoleMiddleware
    participant AdminUserController
    participant UserModel
    participant Database
    
    Admin->>Browser: Navigate to /admin/users
    Browser->>LaravelRouter: GET /admin/users
    LaravelRouter->>RoleMiddleware: Check Role
    
    alt Not Admin
        RoleMiddleware-->>Browser: 403 Forbidden
    else Is Admin
        RoleMiddleware->>AdminUserController: index()
        AdminUserController->>UserModel: Get All Users
        UserModel->>Database: SELECT * FROM users
        Database-->>UserModel: Users Data
        UserModel-->>Browser: Display Users List
    end
    
    Admin->>Browser: Click "Edit User"
    Browser->>LaravelRouter: GET /admin/users/edit/{id}
    LaravelRouter->>AdminUserController: edit()
    AdminUserController->>UserModel: Find User
    UserModel->>Database: SELECT * FROM users WHERE id = ?
    Database-->>UserModel: User Data
    UserModel-->>Browser: Show Edit Form
    
    Admin->>Browser: Update User Info
    Browser->>LaravelRouter: PUT /admin/users/{id}
    LaravelRouter->>AdminUserController: update()
    AdminUserController->>UserModel: Update User
    UserModel->>Database: UPDATE users SET...
    Database-->>UserModel: Success
    UserModel-->>Browser: Success Response
    Browser->>Admin: Show Success Message
```

---

## 13. Event Management Flow

```mermaid
graph TD
    Start["User Access Events"] --> RoleCheck{"Check User Role"}
    
    RoleCheck -->|Admin| AdminEventAccess["Admin Event Management<br/>/admin/events"]
    RoleCheck -->|Alumni/Student| PublicEventAccess["Public Event View<br/>/events"]
    
    AdminEventAccess --> AdminActions{"Admin Actions"}
    AdminActions -->|Create| CreateEvent["POST /admin/events<br/>EventController@store"]
    AdminActions -->|Edit| EditEvent["PUT /admin/events/{id}<br/>EventController@update"]
    AdminActions -->|Delete| DeleteEvent["DELETE /admin/events/{id}<br/>EventController@destroy"]
    AdminActions -->|View| ViewEvent["GET /admin/events<br/>EventController@index"]
    
    PublicEventAccess --> PublicActions{"Public Actions"}
    PublicActions -->|View List| ViewEvents["GET /events<br/>EventController@index"]
    PublicActions -->|View Details| ViewEventDetail["GET /events/{id}<br/>EventController@show"]
    
    CreateEvent --> EventModel["Event Model"]
    EditEvent --> EventModel
    DeleteEvent --> EventModel
    ViewEvent --> EventModel
    ViewEvents --> EventModel
    ViewEventDetail --> EventModel
    
    EventModel --> Database[("MySQL Database<br/>events table")]
```

---

## 14. File Upload and Storage Flow

```mermaid
sequenceDiagram
    participant User
    participant Browser
    participant LaravelController
    participant Validator
    participant Storage
    participant ImageModel
    participant Database
    
    User->>Browser: Select File(s)
    Browser->>LaravelController: POST Request with File(s)
    LaravelController->>Validator: Validate File Type/Size
    
    alt Validation Fails
        Validator-->>Browser: Error Response
        Browser->>User: Show Error Message
    else Validation Passes
        Validator->>LaravelController: Continue
        LaravelController->>Storage: Store File
        Storage-->>LaravelController: File Path
        LaravelController->>ImageModel: Create Image Record
        ImageModel->>Database: INSERT INTO images
        Database-->>ImageModel: Image ID
        ImageModel-->>LaravelController: Image Object
        LaravelController-->>Browser: Success Response
        Browser->>User: Show Success Message
    end
```

---

## 15. Notification System Flow

```mermaid
sequenceDiagram
    participant User
    participant VueComponent
    participant Axios
    participant NotificationController
    participant Database
    
    Note over VueComponent: Component Mounted/Periodic Check
    
    VueComponent->>Axios: GET /api/v1/notifications/unread
    Axios->>NotificationController: getUnreadNotifications()
    NotificationController->>Database: SELECT * FROM notifications WHERE read_at IS NULL
    Database-->>NotificationController: Unread Notifications
    NotificationController-->>Axios: JSON Response
    Axios-->>VueComponent: Update Notification Badge
    VueComponent->>User: Display Notification Count
    
    User->>VueComponent: Click "Mark All as Read"
    VueComponent->>Axios: GET /api/v1/notifications/mark-all-as-read
    Axios->>NotificationController: markAllAsRead()
    NotificationController->>Database: UPDATE notifications SET read_at = NOW()
    Database-->>NotificationController: Success
    NotificationController-->>Axios: Success Response
    Axios-->>VueComponent: Clear Notification Badge
    VueComponent->>User: Update UI
```

---

## 16. Database Schema Overview

```mermaid
erDiagram
    USERS ||--o{ POSTS : creates
    USERS ||--o{ COMMENTS : writes
    USERS ||--o{ LIKES : gives
    USERS ||--o{ JOB_BOARDS : posts
    USERS ||--o{ JOB_APPLICATION_DETAILS : applies
    USERS ||--o{ EVENTS : manages
    USERS }o--|| ROLES : has
    
    POSTS ||--o{ IMAGES : contains
    POSTS ||--o{ COMMENTS : has
    POSTS ||--o{ LIKES : receives
    
    COMMENTS ||--o{ LIKES : receives
    
    JOB_BOARDS ||--o{ JOB_APPLICATION_DETAILS : receives
    
    USERS {
        int id PK
        string name
        string email
        string password
        int role_id FK
        string student_id
        string phone
        text address
        datetime created_at
        datetime updated_at
    }
    
    ROLES {
        int id PK
        string name
        datetime created_at
        datetime updated_at
    }
    
    POSTS {
        int id PK
        int user_id FK
        text content
        datetime created_at
        datetime updated_at
    }
    
    COMMENTS {
        int id PK
        int user_id FK
        int post_id FK
        text content
        datetime created_at
        datetime updated_at
    }
    
    LIKES {
        int id PK
        int user_id FK
        int likeable_id
        string likeable_type
        datetime created_at
        datetime updated_at
    }
    
    IMAGES {
        int id PK
        int imageable_id
        string imageable_type
        string path
        datetime created_at
        datetime updated_at
    }
    
    JOB_BOARDS {
        int id PK
        int user_id FK
        string title
        text description
        string company
        string location
        datetime created_at
        datetime updated_at
    }
    
    JOB_APPLICATION_DETAILS {
        int id PK
        int user_id FK
        int job_board_id FK
        string cv_path
        text cover_letter
        datetime created_at
        datetime updated_at
    }
    
    EVENTS {
        int id PK
        string title
        text description
        datetime event_date
        string location
        datetime created_at
        datetime updated_at
    }
```

---

## 17. API Endpoints Summary

### Authentication Endpoints
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/login` | `AuthenticatedSessionController@create` | Show login form |
| POST | `/login` | `AuthenticatedSessionController@store` | Process login |
| POST | `/logout` | `AuthenticatedSessionController@destroy` | Logout user |
| GET | `/register` | `RegisteredUserController@create` | Show registration form |
| POST | `/register` | `RegisteredUserController@store` | Process registration |

### Public Endpoints (Authenticated Users)
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/` | `HomeController@index` | Home page (Vue.js) |
| GET | `/profile` | `ProfileController@index` | View profile |
| PUT | `/profile/{user_id}` | `ProfileController@update` | Update profile |
| GET | `/events` | `EventController@index` | List events |
| GET | `/alumni-list` | `AlumniListController@index` | List alumni |
| GET | `/student-list` | `StudentListController@index` | List students |
| GET | `/jobs` | `JobBoardController@index` | List jobs |
| POST | `/job/apply` | `JobBoardController@applyJob` | Apply for job |

### API Endpoints (Vue.js - Defined in web.php with Auth Middleware)
**Note**: All API endpoints are defined in `routes/web.php` under the `api/v1` prefix within the auth middleware group.

| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/api/v1/posts` | `PostsApiController` | Get all posts |
| POST | `/api/v1/posts/store` | `CreatePostApiController` | Create post |
| PUT | `/api/v1/posts/{id}` | `UpdatePostApiController` | Update post |
| DELETE | `/api/v1/posts/{id}` | `DeletePostApiController` | Delete post |
| POST | `/api/v1/posts/{post}/like-insert-delete` | `LikeController@likeInsertDeleteToPost` | Toggle like on post |
| GET | `/api/v1/posts/comments/{postId}` | `PostCommentApiController` | Get post comments |
| POST | `/api/v1/posts/comments/{postId}` | `PostCommentController@store` | Create comment |
| PUT | `/api/v1/posts/comments/{id}` | `PostCommentController@update` | Update comment |
| DELETE | `/api/v1/posts/comments/{id}` | `PostCommentController@destroy` | Delete comment |
| POST | `/api/v1/posts/comments/{commentId}/like-insert-delete` | `LikeController@likeInsertDeleteToComment` | Toggle like on comment |
| DELETE | `/api/v1/images/{imageId}` | `ImageDeleteApiController` | Delete image |
| GET | `/api/v1/static-data-for-home-page` | `StaticDataForHomePageApiController` | Get home page data |
| GET | `/api/v1/notifications/unread` | `NotificationController@getUnreadNotifications` | Get unread notifications |
| GET | `/api/v1/notifications/mark-all-as-read` | `NotificationController@markAllAsRead` | Mark all as read |
| GET | `/api/v1/chat/message-count` | `ChatMessageApiController` | Get message count |

### Admin Endpoints
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/admin/dashboard` | `DashboardController@index` | Admin dashboard |
| GET | `/admin/posts` | `PostController@index` | Manage posts |
| GET | `/admin/users` | `AdminUserController@index` | Manage users |
| GET | `/admin/job-board` | `AdminJobBoardController@index` | Manage jobs |
| GET | `/admin/job-board/applicants-list` | `AdminJobBoardController@applicantsIndexForAdmin` | View applicants |
| GET | `/admin/events` | `Backend\EventController@index` | Manage events |

### Alumni Endpoints
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/backend/alumni` | `DashboardController@index` | Alumni dashboard |
| GET | `/backend/alumni/job-board` | `AdminJobBoardController@index` | Manage own jobs |
| GET | `/backend/alumni/job-board/applicants` | `AdminJobBoardController@applicantsIndex` | View applicants |
| GET | `/backend/alumni/download-applicants-cv` | `AdminJobBoardController@downloadCV` | Download CVs |

### Student Endpoints
| Method | Endpoint | Controller | Description |
|--------|----------|------------|-------------|
| GET | `/backend/student` | `DashboardController@index` | Student dashboard |
| GET | `/backend/student/job-applications-list` | `DashboardController@jobApplicationList` | View applications |

---

## 18. Middleware Flow

```mermaid
graph LR
    Request[HTTP Request] --> Web[Web Middleware Group]
    Web --> CSRF[CSRF Protection]
    CSRF --> Session[Session Management]
    Session --> Cookie[Cookie Encryption]
    Cookie --> Auth{Auth Middleware}
    
    Auth -->|Not Authenticated| Login[Redirect to Login]
    Auth -->|Authenticated| RoleCheck{Role Middleware}
    
    RoleCheck -->|Admin| AdminRoutes[Admin Routes]
    RoleCheck -->|Alumni| AlumniRoutes[Alumni Routes]
    RoleCheck -->|Student| StudentRoutes[Student Routes]
    RoleCheck -->|Any Authenticated| PublicRoutes[Public Routes]
    
    AdminRoutes --> Controller[Controller]
    AlumniRoutes --> Controller
    StudentRoutes --> Controller
    PublicRoutes --> Controller
    
    Controller --> Response[HTTP Response]
```

---

## 19. Vue.js Component Structure

```mermaid
graph TD
    App[App Root<br/>resources/js/home/index.js] --> Router[Vue Router]
    Router --> RouterView[RouterView Component]
    RouterView --> Home[Home.vue Component]
    
    Home --> PostFeed[Post Feed Section]
    Home --> CreatePost[Create Post Form]
    Home --> Sidebar[Sidebar Section]
    
    PostFeed --> PostCard[Post Card Component]
    PostCard --> LikeButton[Like Button]
    PostCard --> CommentSection[Comment Section]
    PostCard --> ImageGallery[Image Gallery]
    
    CreatePost --> ImageUploader[Image Uploader]
    CreatePost --> TextEditor[Text Editor]
    
    Sidebar --> EventsList[Events List]
    Sidebar --> UsersList[Users List]
    
    PostCard -->|Axios| API[Laravel API]
    CreatePost -->|Axios| API
    LikeButton -->|Axios| API
    CommentSection -->|Axios| API
```

---

## 20. Request Lifecycle Summary

### For Blade-Rendered Pages:
1. **User Request** → Browser sends HTTP request
2. **Routing** → Laravel Router matches route in `routes/web.php`
3. **Middleware** → Authentication and Role-based middleware checks
4. **Controller** → Controller method processes request
5. **Model** → Eloquent ORM queries database
6. **View** → Blade template rendered with data
7. **Response** → HTML sent back to browser

### For Vue.js API Requests:
1. **User Interaction** → User interacts with Vue component (e.g., clicks like, posts comment)
2. **Axios Request** → Vue component sends HTTP request via Axios to `/api/v1/*` endpoint
3. **Routing** → Laravel Router matches route in `routes/web.php` under `api/v1` prefix
4. **Middleware** → Auth middleware validates session (user must be logged in)
5. **API Controller** → Controller processes API request (e.g., `PostsApiController`, `LikeController`)
6. **Model** → Eloquent ORM queries database (e.g., `Post::all()`, `Like::create()`)
7. **JSON Response** → Controller returns JSON data (e.g., `return response()->json(['data' => $posts])`)
8. **Vue Update** → Axios receives response, Vue component updates reactive data
9. **UI Update** → Browser re-renders component with new data (no page reload)

---

## 21. Security Measures

```mermaid
graph TD
    Security[Security Layers] --> Auth[Authentication]
    Security --> CSRF[CSRF Protection]
    Security --> XSS[XSS Prevention]
    Security --> SQL[SQL Injection Prevention]
    Security --> FileUpload[File Upload Validation]
    
    Auth --> SessionManagement[Session Management]
    Auth --> PasswordHashing[Password Hashing - bcrypt]
    
    CSRF --> TokenVerification[CSRF Token Verification]
    
    XSS --> BladeEscaping[Blade Template Escaping]
    XSS --> InputSanitization[Input Sanitization]
    
    SQL --> EloquentORM[Eloquent ORM]
    SQL --> PreparedStatements[Prepared Statements]
    
    FileUpload --> TypeValidation[File Type Validation]
    FileUpload --> SizeValidation[File Size Validation]
    FileUpload --> StorageSecurity[Secure Storage Path]
```

---

## 22. Deployment Architecture

```mermaid
graph TB
    subgraph "Production Environment"
        WebServer[Web Server<br/>Nginx/Apache]
        PHPServer[PHP-FPM<br/>Laravel Application]
        DBServer[(MySQL Database)]
        FileStorage[File Storage<br/>public/storage]
    end
    
    subgraph "Client Side"
        Browser[Web Browser]
        VueApp[Vue.js Application]
    end
    
    Browser --> WebServer
    VueApp --> WebServer
    WebServer --> PHPServer
    PHPServer --> DBServer
    PHPServer --> FileStorage
    
    WebServer -.->|Static Assets| Browser
    PHPServer -.->|API Responses| VueApp
```

---

## 23. Key Features Summary

### Admin Features
- ✅ User Management (View, Edit Users)
- ✅ Post Management (View, Edit, Delete Posts)
- ✅ Event Management (Create, Edit, Delete Events)
- ✅ Job Board Management (View, Edit, Delete Jobs)
- ✅ View All Job Applicants
- ✅ Download Applicant CVs

### Alumni Features
- ✅ Post Job Opportunities
- ✅ View Applicants for Own Jobs
- ✅ Download CVs
- ✅ Manage Own Job Postings

### Student Features
- ✅ Apply for Jobs
- ✅ View Own Job Applications
- ✅ Upload CV

### Common Features (All Authenticated Users)
- ✅ View Home Feed (Vue.js)
- ✅ Create Posts with Images
- ✅ Edit/Delete Own Posts
- ✅ Like Posts and Comments
- ✅ Comment on Posts
- ✅ View Events
- ✅ View Alumni List
- ✅ View Student List
- ✅ Profile Management
- ✅ Notifications
- ✅ Real-time Updates (Vue.js)

---

## 24. Technology Integration Points

### Laravel + Vue.js Integration
```mermaid
graph LR
    Blade[Blade Template] -->|Renders| VueMount[Vue Mount Point<br/>#home-main-content]
    VueMount -->|Initializes| VueApp[Vue Application]
    VueApp -->|Uses| VueRouter[Vue Router]
    VueApp -->|Communicates via| Axios[Axios HTTP Client]
    Axios -->|Calls| LaravelAPI[Laravel API Routes]
    LaravelAPI -->|Returns| JSON[JSON Response]
    JSON -->|Updates| VueApp
```

### Asset Compilation
```mermaid
graph LR
    Source[Source Files] --> Mix[Laravel Mix<br/>webpack.mix.js]
    Mix -->|Compiles| JS[app.js]
    Mix -->|Compiles| CSS[app.css]
    JS --> Public[public/js]
    CSS --> Public2[public/css]
    Public --> Browser[Browser]
    Public2 --> Browser
```

---

## Conclusion

This document provides a comprehensive overview of the GUB Alumni Portal's system architecture and working flow. The application leverages Laravel's robust backend capabilities combined with Vue.js for a dynamic, interactive home page experience. The role-based access control ensures that different user types (Admin, Alumni, Student) have appropriate access to features and data.

**Key Strengths:**
- Clear separation of concerns (MVC architecture)
- RESTful API design for Vue.js integration
- Role-based access control
- Secure authentication and authorization
- Scalable database design
- Modern frontend with Vue.js

**For Development:**
- Follow Laravel best practices
- Maintain consistent API response formats
- Implement proper error handling
- Write comprehensive tests
- Document API endpoints
- Keep dependencies updated
