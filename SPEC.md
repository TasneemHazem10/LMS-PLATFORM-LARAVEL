# LMS Platform - Technical Specification

## Project Overview
- **Project Name**: LMS Platform (Learning Management System)
- **Type**: Web Application (E-Learning Platform)
- **Core Functionality**: A complete learning management system where users can register, browse courses, enroll, watch lessons, take quizzes, and track progress
- **Target Users**: Admins (manage platform), Students (learn)

## Technology Stack
- **Backend**: Laravel 10.x (PHP 8.1+)
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Database**: MySQL 8.0
- **File Storage**: Local disk storage for videos/images

## User Roles
1. **Admin** - Full platform access
   - Manage users (view, block/unblock)
   - Create/manage categories
   - Create/manage courses
   - Upload lessons
   - View reports/statistics
2. **Student** - Learning access
   - Register/Login
   - Browse courses
   - Enroll in courses
   - Watch lessons
   - Take quizzes
   - Track progress
   - View profile

## Database Schema

### 1. users
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | User's full name |
| email | VARCHAR(255) | Unique email |
| password | VARCHAR(255) | Hashed password |
| role | ENUM | 'admin', 'student' |
| status | ENUM | 'active', 'blocked' |
| avatar | VARCHAR(255) | Profile image path |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

### 2. categories
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| name | VARCHAR(255) | Category name |
| description | TEXT | Category description |
| icon | VARCHAR(255) | Icon class/name |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

### 3. courses
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| title | VARCHAR(255) | Course title |
| description | TEXT | Course description |
| category_id | BIGINT | Foreign key to categories |
| created_by | BIGINT | Foreign key to users |
| thumbnail | VARCHAR(255) | Image path |
| price | DECIMAL(10,2) | Course price (0 = free) |
| status | ENUM | 'published', 'draft' |
| is_featured | BOOLEAN | Featured course flag |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

### 4. lessons
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| course_id | BIGINT | Foreign key to courses |
| title | VARCHAR(255) | Lesson title |
| video_path | VARCHAR(255) | Video file path |
| content_text | TEXT | Lesson content |
| duration | INT | Duration in minutes |
| lesson_order | INT | Order in course |
| created_at | TIMESTAMP | Creation time |
| updated_at | TIMESTAMP | Update time |

### 5. enrollments
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | Foreign key to users |
| course_id | BIGINT | Foreign key to courses |
| progress | INT | Progress percentage (0-100) |
| is_completed | BOOLEAN | Course completion status |
| enrolled_at | TIMESTAMP | Enrollment time |
| completed_at | TIMESTAMP | Completion time |

### 6. lesson_progress
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | Foreign key to users |
| lesson_id | BIGINT | Foreign key to lessons |
| is_completed | BOOLEAN | Lesson completion status |
| watched_at | TIMESTAMP | Last watched time |

### 7. quizzes
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| lesson_id | BIGINT | Foreign key to lessons |
| question | TEXT | Quiz question |
| option_a | VARCHAR(255) | Option A |
| option_b | VARCHAR(255) | Option B |
| option_c | VARCHAR(255) | Option C |
| option_d | VARCHAR(255) | Option D |
| correct_answer | ENUM | 'a', 'b', 'c', 'd' |
| created_at | TIMESTAMP | Creation time |

### 8. quiz_results
| Column | Type | Description |
|--------|------|-------------|
| id | BIGINT | Primary key |
| user_id | BIGINT | Foreign key to users |
| quiz_id | BIGINT | Foreign key to quizzes |
| selected_answer | ENUM | 'a', 'b', 'c', 'd' |
| is_correct | BOOLEAN | Answer correctness |
| created_at | TIMESTAMP | Submission time |

## Page Structure

### Public Pages (No Auth Required)
- `/` - Home page with featured courses
- `/courses` - Course catalog with filters
- `/course/{id}` - Course details page
- `/login` - Login form
- `/register` - Registration form

### Student Pages (Auth Required)
- `/dashboard` - Student dashboard with enrolled courses
- `/my-courses` - List of enrolled courses
- `/course/{id}/learn` - Course player with lessons
- `/lesson/{id}` - Watch individual lesson
- `/lesson/{id}/quiz` - Take quiz for lesson
- `/profile` - User profile settings

### Admin Pages (Admin Only)
- `/admin` - Admin dashboard with statistics
- `/admin/users` - Manage users
- `/admin/categories` - Manage categories
- `/admin/courses` - Manage courses
- `/admin/courses/create` - Create new course
- `/admin/courses/{id}/edit` - Edit course
- `/admin/courses/{id}/lessons` - Manage course lessons
- `/admin/enrollments` - View all enrollments
- `/admin/reports` - View platform reports

## API Routes

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user
- `GET /api/user` - Get current user

### Courses
- `GET /api/courses` - List all published courses
- `GET /api/courses/{id}` - Get course details
- `POST /api/courses` - Create course (admin)
- `PUT /api/courses/{id}` - Update course (admin)
- `DELETE /api/courses/{id}` - Delete course (admin)

### Lessons
- `GET /api/courses/{id}/lessons` - Get course lessons
- `GET /api/lessons/{id}` - Get lesson details
- `POST /api/lessons` - Create lesson (admin)
- `PUT /api/lessons/{id}` - Update lesson (admin)
- `DELETE /api/lessons/{id}` - Delete lesson (admin)

### Enrollment
- `POST /api/enroll/{course_id}` - Enroll in course
- `GET /api/enrollments` - Get user enrollments
- `POST /api/lessons/{id}/complete` - Mark lesson complete

### Quizzes
- `GET /api/lessons/{id}/quiz` - Get lesson quiz
- `POST /api/quiz/{id}/submit` - Submit quiz answer

## Security Requirements
1. Passwords hashed with bcrypt
2. Role-based access control (RBAC)
3. Middleware for auth verification
4. CSRF protection on forms
5. Input validation on all requests
6. Prevent direct lesson access without enrollment

## File Storage Structure
```
storage/
├── app/
│   └── public/
│       ├── thumbnails/    # Course thumbnails
│       ├── videos/         # Lesson videos
│       └── avatars/        # User avatars
```

## UI/UX Requirements
1. Clean, modern design
2. Responsive (mobile-friendly)
3. Progress bars for courses
4. Video player for lessons
5. Toast notifications for actions
6. Loading states for async operations
7. Separate layouts for admin and student

## Color Scheme
- Primary: #4F46E5 (Indigo)
- Secondary: #10B981 (Emerald)
- Background: #F9FAFB (Light gray)
- Surface: #FFFFFF (White)
- Text: #1F2937 (Dark gray)
- Error: #EF4444 (Red)
- Success: #10B981 (Green)

## Acceptance Criteria
1. ✅ Users can register and login with role selection
2. ✅ Admins can create categories and courses
3. ✅ Admins can upload lessons with videos
4. ✅ Students can browse and enroll in courses
5. ✅ Students can watch lessons sequentially
6. ✅ Progress is tracked automatically
7. ✅ Quizzes work correctly with instant feedback
8. ✅ Dashboard shows accurate statistics
9. ✅ All pages are responsive
10. ✅ File uploads work correctly
