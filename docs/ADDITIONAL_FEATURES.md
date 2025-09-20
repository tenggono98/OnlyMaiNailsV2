# Additional Features & Security Documentation

This document covers the missing features, security aspects, and advanced components discovered in the codebase scan.

## Table of Contents

1. [Additional Admin Components](#additional-admin-components)
2. [User Management Components](#user-management-components)
3. [Mail System](#mail-system)
4. [Security & Middleware](#security--middleware)
5. [Database Utilities](#database-utilities)
6. [Console Commands](#console-commands)
7. [Additional Models](#additional-models)
8. [Configuration Files](#configuration-files)
9. [Security Features](#security-features)
10. [Performance Features](#performance-features)
11. [Integration Features](#integration-features)

---

## Additional Admin Components

### Admin/Booking Component

**Location:** `app/Livewire/Admin/Booking.php`

**Purpose:** Comprehensive booking management system for administrators.

**Public Properties:**
- `$booking` (collection) - Booking records with filtering
- `$clientBook` (object) - Selected client for booking
- `$dateBook` (string) - Selected booking date
- `$timeBook` (string) - Selected booking time
- `$servicsBook` (array) - Selected services for booking
- `$totalPriceBook` (float) - Calculated total price
- `$qtyBook` (int) - Quantity of people
- `$tax` (bool) - Tax application flag
- `$deposit` (float) - Deposit amount

**Search Properties:**
- `$searchStartDate` (string) - Start date filter
- `$searchEndDate` (string) - End date filter
- `$searchStatus` (string) - Status filter
- `$searchBookingCode` (string) - Booking code filter
- `$searchDepositStatus` (string) - Deposit payment status filter

**Public Methods:**

#### `render()`
Renders the booking management interface with filtered data.

**Features:**
- Date range filtering
- Status filtering (active/inactive)
- Booking code search
- Deposit payment status filtering
- Automatic price calculation with tax
- Real-time service selection

#### `save()`
Creates or updates a booking record.

**Features:**
- Validates all required fields
- Handles both create and edit modes
- Updates schedule availability
- Creates detailed service records
- Generates unique booking codes and UUIDs

**Example:**
```php
// Set booking data
$this->clientBook = $user;
$this->dateBook = '2024-01-15';
$this->timeBook = '14:00';
$this->servicsBook = $selectedServices;
$this->qtyBook = 2;

// Save booking
$this->save();
```

#### `edit($id)`
Loads booking data for editing.

**Parameters:**
- `$id` (int) - Booking ID to edit

#### `confirmDepositPayment($id)`
Confirms or cancels deposit payment for a booking.

**Parameters:**
- `$id` (int) - Booking ID

**Features:**
- Toggles deposit payment status
- Updates schedule availability
- Generates PDF confirmations and invoices
- Sends email notifications to clients
- Creates system notifications
- Manages booking status

#### `completeBooking($uuid)`
Marks a booking as completed.

**Parameters:**
- `$uuid` (string) - Booking UUID

**Features:**
- Updates booking status to 'completed'
- Creates completion notifications
- Tracks booking lifecycle

#### `bookmarkGoogleCalendar($user, $booking)`
Generates Google Calendar link for booking.

**Parameters:**
- `$user` (int) - User ID
- `$booking` (int) - Booking ID

**Returns:** Google Calendar URL with booking details

**Features:**
- Creates calendar event with booking details
- Includes client email for invitations
- Sets proper timezone
- Dispatches calendar link to frontend

#### `toggleStatus($id)`
Toggles booking status (active/inactive).

**Parameters:**
- `$id` (int) - Booking ID

---

### Admin/Service Component

**Location:** `app/Livewire/Admin/Service.php`

**Purpose:** Service catalog management for administrators.

**Public Properties:**
- `$serviceName` (string) - Service name
- `$serviceCategory` (int) - Service category ID
- `$servicePrice` (float) - Service price
- `$serviceOrder` (int) - Display order
- `$isMerge` (bool) - Merge service flag

**Search Properties:**
- `$searchName` (string) - Service name filter
- `$searchCategory` (int) - Category filter
- `$searchStatus` (string) - Status filter

**Public Methods:**

#### `render()`
Renders service management interface with filtering.

**Features:**
- Name-based search
- Category filtering
- Status filtering
- Ordered display by category and order

#### `save()`
Creates or updates a service.

**Features:**
- Validates required fields
- Handles create/edit modes
- Auto-reorders services in category
- Maintains service hierarchy

#### `edit($id)`
Loads service data for editing.

**Parameters:**
- `$id` (int) - Service ID

#### `toggleStatus($id)`
Toggles service status (active/inactive).

**Parameters:**
- `$id` (int) - Service ID

#### `confirmDelete($name, $id)`
Confirms service deletion with confirmation modal.

**Parameters:**
- `$name` (string) - Service name for display
- `$id` (int) - Service ID

#### `deleteRow()`
Deletes a service and reorders remaining services.

**Features:**
- Soft deletes service record
- Reorders remaining services in category
- Maintains data integrity

---

### Admin/Users Component

**Location:** `app/Livewire/Admin/Users.php`

**Purpose:** User management system for administrators.

**Public Properties:**
- `$userType` (string) - User type filter ('admin' or 'user')
- `$fullnameUser` (string) - User full name
- `$phoneUser` (string) - User phone number
- `$emailUser` (string) - User email
- `$passwordUser` (string) - User password
- `$igUser` (string) - Instagram handle (for users)

**Warning Notes Properties:**
- `$nameUserWarningNotes` (string) - User name for notes
- `$userNotesWarning` (collection) - User warning notes
- `$descriptionWarningNote` (string) - Note description

**Public Methods:**

#### `render()`
Renders user management interface filtered by type.

#### `save()`
Creates or updates a user account.

**Features:**
- Handles both admin and user creation
- Password hashing
- Role assignment
- Status management

#### `edit($idUser)`
Loads user data for editing.

**Parameters:**
- `$idUser` (int) - User ID

#### `viewWarningNotes($userId)`
Displays warning notes for a specific user.

**Parameters:**
- `$userId` (int) - User ID

#### `saveNote()`
Saves or updates a warning note.

**Features:**
- Creates new notes or updates existing ones
- Associates notes with specific users
- Tracks note creation by admin

#### `editInlineNote($id)`
Loads note data for inline editing.

**Parameters:**
- `$id` (int) - Note ID

#### `DeleteInlineNote($id)`
Deletes a warning note.

**Parameters:**
- `$id` (int) - Note ID

---

### Admin/Schedule Component

**Location:** `app/Livewire/Admin/Schedule.php`

**Purpose:** Schedule management for available booking times.

**Public Properties:**
- `$scheduleDate` (string) - Schedule date
- `$timeArray` (array) - Array of available times
- `$timeCount` (int) - Number of time slots

**Search Properties:**
- `$searchStartDate` (string) - Start date filter
- `$searchEndDate` (string) - End date filter
- `$searchStatus` (string) - Status filter

**Public Methods:**

#### `render()`
Renders schedule management with pagination and filtering.

**Features:**
- Date range filtering
- Status filtering
- Paginated results (10 per page)
- Related time slots display

#### `save()`
Creates or updates schedule with time slots.

**Features:**
- Validates date uniqueness
- Creates master schedule record
- Creates detailed time slot records
- Handles both create and edit modes

#### `edit($id)`
Loads schedule data for editing.

**Parameters:**
- `$id` (int) - Schedule ID

#### `addTimeModal()`
Adds a new time slot to the form.

#### `deleteTimeModal($index)`
Removes a time slot from the form.

**Parameters:**
- `$index` (int) - Array index to remove

---

### Admin/Setting Component

**Location:** `app/Livewire/Admin/Setting.php`

**Purpose:** Application settings management.

**Public Properties:**
- `$tax` (float) - Tax percentage
- `$deposit` (float) - Deposit percentage
- `$emailPayment` (string) - Payment email
- `$limitDepositTime` (int) - Deposit payment time limit (hours)
- `$address` (string) - Business address
- `$gmap_links` (string) - Google Maps links
- `$instagram` (string) - Instagram handle

**Public Methods:**

#### `render()`
Loads current settings from database.

#### `save()`
Updates all application settings.

**Features:**
- Bulk updates multiple settings
- Validates all input fields
- Maintains setting consistency

---

### Admin/HomepageImages Component

**Location:** `app/Livewire/Admin/HomepageImages.php`

**Purpose:** Homepage image management system.

**Public Properties:**
- `$images` (collection) - Current images
- `$newImage` (file) - New image upload
- `$section` (string) - Image section ('header' or 'promo')
- `$altText` (string) - Image alt text
- `$displayOrder` (int) - Display order

**Public Methods:**

#### `render()`
Renders image management interface.

#### `loadImages()`
Loads images for current section.

#### `save()`
Uploads and saves new image.

**Features:**
- File validation (image types, size, dimensions)
- Stores in public storage
- Creates database record
- Maintains display order

#### `toggleStatus($id)`
Toggles image visibility.

**Parameters:**
- `$id` (int) - Image ID

#### `delete($id)`
Deletes image and removes file.

**Parameters:**
- `$id` (int) - Image ID

**Features:**
- Removes file from storage
- Deletes database record
- Maintains data integrity

#### `switchSection($section)`
Switches between image sections.

**Parameters:**
- `$section` (string) - Section name

---

### Admin/ReviewUser Component

**Location:** `app/Livewire/Admin/ReviewUser.php`

**Purpose:** User review management system.

**Public Methods:**

#### `render()`
Displays all user reviews.

#### `toggleShow($id)`
Toggles review visibility on website.

**Parameters:**
- `$id` (int) - Review ID

#### `toggleStatus($id)`
Toggles review status (active/inactive).

**Parameters:**
- `$id` (int) - Review ID

#### `confirmDelete($name, $id)`
Confirms review deletion.

**Parameters:**
- `$name` (string) - Reviewer name
- `$id` (int) - Review ID

#### `deleteRow()`
Deletes a review.

---

## User Management Components

### User/RescheduleorCancel Component

**Location:** `app/Livewire/User/RescheduleorCancel.php`

**Purpose:** User booking management (reschedule/cancel).

**Public Properties:**
- `$booking` (object) - Booking details
- `$detailBooking` (collection) - Booking services
- `$deposit` (float) - Deposit amount
- `$paymentEmail` (string) - Payment email
- `$timeRemaining` (string) - Time remaining for deposit
- `$isExpired` (bool) - Deposit expiration status
- `$dateBook` (string) - New booking date
- `$timeBook` (string) - New booking time

**Public Methods:**

#### `mount($uuid)`
Initializes component with booking data.

**Parameters:**
- `$uuid` (string) - Booking UUID

**Features:**
- Validates booking ownership
- Initializes deposit timer
- Loads booking details

#### `cancelBooking($uuid)`
Cancels a booking.

**Parameters:**
- `$uuid` (string) - Booking UUID

**Features:**
- Updates booking status to 'cancel'
- Frees up schedule slot
- Records cancellation details

#### `rescheduleBooking()`
Reschedules a booking to new date/time.

**Features:**
- Creates new booking record
- Marks old booking as rescheduled
- Updates schedule availability
- Copies service details
- Sends notifications to admins
- Limits to one reschedule per booking

#### `confirmDeposit()`
Sends deposit confirmation request to admins.

**Features:**
- Creates admin notifications
- Sends email notifications
- Prevents duplicate notifications
- Tracks confirmation requests

#### `initializeTimer()`
Initializes deposit payment timer.

**Features:**
- Calculates time remaining based on settings
- Handles expiration logic
- Updates UI with countdown

#### `checkTimeRemaining()`
Checks and updates timer status.

---

## Mail System

### MailBooking Mailable

**Location:** `app/Mail/MailBooking.php`

**Purpose:** Sends booking confirmation emails with attachments.

**Public Properties:**
- `$mailData` (array) - Email data including files
- `$company` (array) - Company information

**Features:**
- Professional email template
- PDF attachments (confirmation + invoice)
- Company branding
- Booking details included

**Usage:**
```php
$mailData = [
    'clientName' => 'John Doe',
    'booking_date' => 'Monday, 15 January 2024',
    'booking_time' => '2:00 PM',
    'uuid' => 'ABC123',
    'services' => $servicesArray,
    'files' => [
        public_path('PDF_Booking_Confirmation/confirmation.pdf'),
        public_path('PDF_Booking_Invoice/invoice.pdf')
    ]
];

Mail::to($client->email)->send(new MailBooking($mailData));
```

---

## Security & Middleware

### Custom Middleware

#### RedirectToUserLogin

**Location:** `app/Http/Middleware/RedirectToUserLogin.php`

**Purpose:** Redirects unauthenticated users to login page.

**Features:**
- Stores intended URL for post-login redirect
- Redirects to user login route
- Maintains user experience flow

#### RoleCheck

**Location:** `app/Http/Middleware/RoleCheck.php`

**Purpose:** Role-based access control middleware.

**Parameters:**
- `...$roles` - Allowed roles for the route

**Features:**
- Validates user authentication
- Checks user role against allowed roles
- Logs out unauthorized users
- Redirects based on user role
- Prevents admin access by regular users

**Usage:**
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin-only routes
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // User-only routes
});
```

---

## Database Utilities

### ActionDatabase Controller

**Location:** `app/Http/Controllers/ActionDatabase.php`

**Purpose:** Utility controller for common database operations.

#### `deleteSingleModel($modelName, $id)`
Soft deletes a model record.

**Parameters:**
- `$modelName` (string) - Model class name
- `$id` (int) - Record ID

**Returns:** `bool` - Success status

**Example:**
```php
$success = ActionDatabase::deleteSingleModel('TBooking', 123);
```

#### `toggleStatusSingleModel($modelName, $id)`
Toggles model status (active/inactive).

**Parameters:**
- `$modelName` (string) - Model class name
- `$id` (int) - Record ID

**Returns:** `bool` - Success status

**Example:**
```php
$success = ActionDatabase::toggleStatusSingleModel('MService', 456);
```

---

## Console Commands

### MailTester Command

**Location:** `app/Console/Commands/MailTester.php`

**Purpose:** Tests email functionality.

**Command:** `php artisan app:mail-tester`

**Features:**
- Sends test email to configured address
- Validates mail configuration
- Useful for debugging email issues

---

## Additional Models

### Notification Model

**Location:** `app/Models/Notification.php`

**Purpose:** System notification management.

**Features:**
- In-app notifications
- Role-based targeting
- URL linking
- Read status tracking

### UserWarningNotes Model

**Location:** `app/Models/UserWarningNotes.php`

**Purpose:** User warning notes system.

**Relationships:**
- `user()` - Belongs to User (note_for)
- `account()` - Belongs to User (created_by)

### DocumentRecord Model

**Location:** `app/Models/DocumentRecord.php`

**Purpose:** Tracks generated documents.

**Features:**
- PDF generation tracking
- Reference ID linking
- Creator tracking
- Document type classification

### HomepageImage Model

**Location:** `app/Models/HomepageImage.php`

**Purpose:** Homepage image management.

**Fillable Attributes:**
- `image_path` (string)
- `alt_text` (string)
- `display_order` (int)
- `section` (string)
- `status` (string)
- `created_by` (int)
- `updated_by` (int)

**Relationships:**
- `createdBy()` - Belongs to User
- `updatedBy()` - Belongs to User

### ReviewUser Model

**Location:** `app/Models/ReviewUser.php`

**Purpose:** User review system.

**Relationships:**
- `booking()` - Belongs to TBooking
- `user()` - Belongs to User (created_by)

---

## Configuration Files

### Livewire Alert Configuration

**Location:** `config/livewire-alert.php`

**Purpose:** Configures SweetAlert2 integration.

**Settings:**
- Alert positioning and timing
- Confirmation dialog settings
- Toast notifications
- Button configurations

### DOMPDF Configuration

**Location:** `config/dompdf.php`

**Purpose:** PDF generation settings.

**Key Settings:**
- Font directory and cache
- Security settings (chroot)
- Image DPI settings
- Paper size and orientation
- Remote file access controls

---

## Security Features

### Authentication Security
- **Email Verification:** Required for user accounts
- **Password Hashing:** Automatic password hashing
- **Session Management:** Secure session handling
- **OAuth Integration:** Google OAuth for easy login

### Authorization Security
- **Role-Based Access:** Admin and user role separation
- **Route Protection:** Middleware-based route protection
- **Ownership Validation:** Users can only access their own data
- **Admin Privileges:** Restricted admin-only functionality

### Data Security
- **Input Validation:** Comprehensive form validation
- **SQL Injection Protection:** Eloquent ORM usage
- **File Upload Security:** Image validation and storage
- **CSRF Protection:** Laravel's built-in CSRF tokens

### Business Logic Security
- **Booking Ownership:** Users can only manage their bookings
- **Schedule Protection:** Prevents double-booking
- **Deposit Time Limits:** Automatic booking expiration
- **Reschedule Limits:** One reschedule per booking

---

## Performance Features

### Caching
- **Query Optimization:** Efficient database queries
- **Image Optimization:** Proper image handling
- **Pagination:** Large dataset pagination

### Rate Limiting
- **Booking Form:** 20 requests per minute
- **API Protection:** Prevents abuse

### File Management
- **Storage Optimization:** Organized file storage
- **Cleanup Procedures:** Automatic file cleanup
- **Document Tracking:** PDF generation tracking

---

## Integration Features

### Google Calendar Integration
- **Event Creation:** Automatic calendar event generation
- **Client Invitations:** Email invitations for events
- **Timezone Support:** Proper timezone handling

### Email Integration
- **SMTP Configuration:** Professional email delivery
- **Template System:** Branded email templates
- **Attachment Support:** PDF document attachments

### PDF Generation
- **Professional Documents:** Branded PDF generation
- **Multiple Formats:** Confirmation and invoice PDFs
- **Document Tracking:** Generation history tracking

---

## Error Handling

### User-Friendly Errors
- **Validation Messages:** Clear form validation errors
- **Business Logic Errors:** Meaningful error messages
- **System Errors:** Graceful error handling

### Logging
- **Email Failures:** Email sending error logging
- **Database Errors:** Database operation logging
- **Security Events:** Authentication and authorization logging

---

This comprehensive documentation covers all additional features, security aspects, and advanced components discovered in the codebase scan. Combined with the main API documentation, this provides complete coverage of the application's functionality.