# API Documentation

This document provides comprehensive documentation for all public APIs, functions, and components in the Laravel application.

## Table of Contents

1. [Global Helper Functions](#global-helper-functions)
2. [Models and Eloquent Relationships](#models-and-eloquent-relationships)
3. [Livewire Components](#livewire-components)
4. [HTTP Controllers](#http-controllers)
5. [Routes and Endpoints](#routes-and-endpoints)
6. [Authentication & Authorization](#authentication--authorization)
7. [PDF Generation](#pdf-generation)

---

## Global Helper Functions

### `generateBookingCode($length = 6)`

Generates a unique booking code for appointments.

**Parameters:**
- `$length` (int, optional): Length of the random string part. Default: 6

**Returns:** `string` - A booking code in format: `{RANDOM_STRING}{TIMESTAMP}`

**Example:**
```php
$bookingCode = generateBookingCode(); // Returns: "ABC1234567"
$bookingCode = generateBookingCode(8); // Returns: "XYZ987654321"
```

**Usage:**
```php
// Generate a booking code for a new appointment
$code = generateBookingCode();
$booking->code_booking = $code;
```

---

### `generateUUID($length = 30)`

Generates a unique identifier (UUID) based on timestamp and random string.

**Parameters:**
- `$length` (int, optional): Length of the random string part. Default: 30

**Returns:** `string` - A UUID in format: `{TIMESTAMP}-{RANDOM_STRING}`

**Example:**
```php
$uuid = generateUUID(); // Returns: "1703123456789-ABCDEFGHIJKLMNOPQRSTUVWXYZ1234"
$uuid = generateUUID(20); // Returns: "1703123456789-ABCDEFGHIJKLMNOPQRST"
```

**Usage:**
```php
// Generate UUID for booking reference
$uuid = generateUUID();
$booking->uuid = $uuid;
```

---

### `getSettingWeb($name)`

Retrieves a web setting value by name from the database.

**Parameters:**
- `$name` (string): The name of the setting to retrieve

**Returns:** `string` - The setting value

**Example:**
```php
$email = getSettingWeb('PaymentEmail'); // Returns: "contact@example.com"
$address = getSettingWeb('Address'); // Returns: "123 Main St, City"
```

**Usage:**
```php
// Get contact email for notifications
$contactEmail = getSettingWeb('PaymentEmail');

// Get business address
$businessAddress = getSettingWeb('Address');
```

**Available Settings:**
- `PaymentEmail` - Contact email for payments
- `Address` - Business address
- `Instagram` - Instagram handle
- `Gmaps` - Google Maps link
- `Deposit` - Deposit percentage
- `gmapsLinks` - Google Maps links

---

## Models and Eloquent Relationships

### User Model

**Location:** `app/Models/User.php`

**Fillable Attributes:**
- `name` (string)
- `email` (string)
- `password` (string)
- `gauth_id` (string) - Google OAuth ID
- `gauth_type` (string) - OAuth provider type
- `role` (string) - User role ('admin' or 'user')

**Public Methods:**

#### `isAdmin()`
Returns true if user has admin role.

**Returns:** `bool`

**Example:**
```php
if ($user->isAdmin()) {
    // User is an admin
}
```

#### `isUser()`
Returns true if user has user role.

**Returns:** `bool`

**Example:**
```php
if ($user->isUser()) {
    // User is a regular user
}
```

**Relationships:**
- `total_order()` - Has many TBooking records
- `warningNotes()` - Has many UserWarningNotes records

---

### TBooking Model

**Location:** `app/Models/TBooking.php`

**Relationships:**

#### `client()`
Returns the user who made the booking.

**Returns:** `BelongsTo` relationship to User model

**Example:**
```php
$booking = TBooking::find(1);
$clientName = $booking->client->name;
```

#### `detailService()`
Returns all service details for the booking.

**Returns:** `HasMany` relationship to TDBooking model

**Example:**
```php
$booking = TBooking::find(1);
$services = $booking->detailService;
foreach ($services as $service) {
    echo $service->service->name_service;
}
```

#### `scheduleDateBook()`
Returns the scheduled date for the booking.

**Returns:** `BelongsTo` relationship to TSchedule model

**Example:**
```php
$booking = TBooking::find(1);
$date = $booking->scheduleDateBook->date_schedule;
```

#### `scheduleTimeBook()`
Returns the scheduled time for the booking.

**Returns:** `BelongsTo` relationship to TDSchedule model

**Example:**
```php
$booking = TBooking::find(1);
$time = $booking->scheduleTimeBook->time;
```

#### `review()`
Returns the review associated with the booking.

**Returns:** `HasOne` relationship to ReviewUser model

**Example:**
```php
$booking = TBooking::find(1);
$review = $booking->review;
if ($review) {
    echo $review->description_review;
}
```

---

### MService Model

**Location:** `app/Models/MService.php`

**Relationships:**

#### `category()`
Returns the service category.

**Returns:** `BelongsTo` relationship to MServiceCategory model

**Example:**
```php
$service = MService::find(1);
$categoryName = $service->category->name_category;
```

---

### SettingWeb Model

**Location:** `app/Models/SettingWeb.php`

**Purpose:** Stores application configuration settings.

**Common Settings:**
- `PaymentEmail` - Contact email for payments
- `Address` - Business address
- `Instagram` - Instagram handle
- `Gmaps` - Google Maps link
- `Deposit` - Deposit percentage

**Example:**
```php
$setting = SettingWeb::where('name', 'PaymentEmail')->first();
$email = $setting->value;
```

---

## Livewire Components

### V2/Homepage Component

**Location:** `app/Livewire/V2/Homepage.php`

**Purpose:** Displays the main homepage with settings and images.

**Public Methods:**

#### `render()`
Renders the homepage view with required data.

**Returns:** `View` - The homepage view

**Data Provided:**
- `$data_homepage` - Array containing:
  - `gmapsLinks` - Google Maps links
  - `address` - Business address
  - `instagram` - Instagram handle
  - `email` - Payment email
- `$headerImages` - Header section images
- `$promoImages` - Promotional images

**Usage:**
```php
// Component is automatically rendered when route is accessed
Route::get('/', \App\Livewire\V2\Homepage::class)->name('home');
```

---

### V2/Services Component

**Location:** `app/Livewire/V2/Services.php`

**Purpose:** Displays available services organized by category.

**Public Methods:**

#### `render()`
Renders the services view with categorized services.

**Returns:** `View` - The services view

**Data Provided:**
- `$services` - Collection of service categories with their active services

**Usage:**
```php
// Component is automatically rendered when route is accessed
Route::get('/services', \App\Livewire\V2\Services::class)->name('services');
```

---

### Component/Module/ServiceSelector

**Location:** `app/Livewire/Component/Module/ServiceSelector.php`

**Purpose:** Reusable component for selecting services during booking.

**Public Properties:**
- `$searchTerm` (string) - Search term for filtering services
- `$selectedServices` (array) - Currently selected services
- `$services` (array) - Available services based on search
- `$servicesCategory` (collection) - Available service categories
- `$servicesCategorySelected` (int) - Selected category ID
- `$servicsBook` (object) - Services selected for booking

**Public Methods:**

#### `mount()`
Initializes the component with service categories.

**Example:**
```php
// Component is mounted automatically when included
<livewire:component.module.service-selector />
```

#### `updatedSearchTerm()`
Filters services based on search term and selected category.

**Example:**
```php
// Triggered when user types in search field
$this->searchTerm = 'massage';
// Services are automatically filtered
```

#### `selectService($servicesId)`
Adds a service to the booking selection.

**Parameters:**
- `$servicesId` (int) - ID of the service to select

**Example:**
```php
$this->selectService(5); // Adds service with ID 5 to selection
```

#### `clearSelection()`
Clears all selected services and resets the component.

**Example:**
```php
$this->clearSelection(); // Resets all selections
```

---

### Component/Module/DatePickerCalender

**Location:** `app/Livewire/Component/Module/DatePickerCalender.php`

**Purpose:** Date picker component for selecting available booking dates.

**Public Properties:**
- `$dateBook` (string) - Selected booking date

**Public Methods:**

#### `render()`
Renders the date picker with available dates.

**Returns:** `View` - The date picker view

**Features:**
- Dispatches `enabledDatesUpdated` event with available dates
- Only shows dates from today onwards
- Only shows dates with available schedules

**Usage:**
```php
// Component automatically loads available dates
<livewire:component.module.date-picker-calender />
```

---

### User/HistoryBooking Component

**Location:** `app/Livewire/User/HistoryBooking.php`

**Purpose:** Displays user's booking history with filtering and review capabilities.

**Public Properties:**
- `$dateSearch` (string) - Filter by date
- `$codeSearch` (string) - Filter by booking code
- `$statusSearch` (string) - Filter by status
- `$bookingData` (collection) - User's booking records
- `$reviewDescription` (string) - Review text
- `$idBooking` (int) - Booking ID for review

**Public Methods:**

#### `mount()`
Loads user's booking history with optional filters.

**Example:**
```php
// Component loads automatically when route is accessed
Route::get('/book/history_booking', \App\Livewire\User\HistoryBooking::class)
    ->name('user.history_booking');
```

#### `clearSearch()`
Clears all search filters and reloads data.

**Returns:** `Redirect` - Redirects to history page

**Example:**
```php
$this->clearSearch(); // Clears filters and reloads
```

#### `setIdBooking($idBooking)`
Sets the booking ID for review submission.

**Parameters:**
- `$idBooking` (int) - Booking ID

**Example:**
```php
$this->setIdBooking(123); // Sets booking ID for review
```

#### `leaveReview()`
Submits a review for a booking.

**Example:**
```php
$this->reviewDescription = 'Great service!';
$this->leaveReview(); // Submits the review
```

**Status Filter Options:**
- `completed` - Completed bookings
- `cancel` - Cancelled bookings
- `1` - Confirmed bookings with deposit paid
- `reschedule` - Rescheduled bookings
- `1&0` - Confirmed bookings without payment confirmation
- `1&1` - Confirmed bookings with payment confirmation but no deposit

---

## HTTP Controllers

### OauthController

**Location:** `app/Http/Controllers/OauthController.php`

**Purpose:** Handles Google OAuth authentication.

#### `redirectToProvider()`
Redirects user to Google OAuth provider.

**Returns:** `Redirect` - Redirect to Google OAuth

**Route:** `GET /oauth/google`

**Example:**
```php
// Redirect to Google OAuth
return redirect()->route('oauth.google');
```

#### `handleProviderCallback()`
Handles the OAuth callback from Google.

**Returns:** `Redirect` - Redirect to homepage after login

**Route:** `GET /oauth/google/callback`

**Features:**
- Creates new user if not exists
- Logs in existing user
- Generates random password for new users
- Sets role to 'user' for new registrations

**Example:**
```php
// After successful OAuth, user is redirected to homepage
// New users are automatically created and logged in
```

---

### PDF Controllers

#### BookingComplete

**Location:** `app/Http/Controllers/Pdf/BookingComplete.php`

**Purpose:** Generates PDF confirmation documents for bookings.

#### `show()`
Shows a test PDF view (for development).

**Returns:** `View` - PDF test view

**Route:** `GET /pdf_view`

#### `createPDF($id)`
Generates and saves a PDF confirmation for a booking.

**Parameters:**
- `$id` (int) - Booking ID

**Returns:** `string` - Path to saved PDF file

**Features:**
- Creates PDF_Booking_Confirmation directory if needed
- Records document generation in DocumentRecord
- Includes booking details, client info, and business settings
- Saves with timestamped filename

**Example:**
```php
$pdfPath = BookingComplete::createPDF(123);
// PDF saved to: PDF_Booking_Confirmation/OMN_Appointment_Confirmation_25-12-2023_ABC123.pdf
```

**PDF Content Includes:**
- Client name
- Booking date and time
- Service list
- Reschedule token
- Quantity of people
- Deposit price
- Tax information
- Business contact details

---

## Routes and Endpoints

### Public Routes

#### Homepage
```php
Route::get('/', \App\Livewire\V2\Homepage::class)->name('home');
```
- **Method:** GET
- **Purpose:** Main homepage
- **Access:** Public

#### Services
```php
Route::get('/services', \App\Livewire\V2\Services::class)->name('services');
```
- **Method:** GET
- **Purpose:** Services listing page
- **Access:** Public

#### Booking
```php
Route::get('/book', \App\Livewire\Book::class)->middleware('throttle:20,1')->name('book');
```
- **Method:** GET
- **Purpose:** Booking form
- **Access:** Public
- **Rate Limit:** 20 requests per minute

#### Contact
```php
Route::get('/contact_us', \App\Livewire\ContactUs::class)->name('contact_us');
```
- **Method:** GET
- **Purpose:** Contact form
- **Access:** Public

### Authentication Routes

#### Google OAuth
```php
Route::get('oauth/google', [OauthController::class, 'redirectToProvider'])->name('oauth.google');
Route::get('oauth/google/callback', [OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');
```
- **Method:** GET
- **Purpose:** Google OAuth authentication
- **Access:** Public

### User Routes (Protected)

#### User Profile
```php
Route::get('/change_profile', \App\Livewire\User\ChangeProfile::class)->name('user.change_profile');
```
- **Method:** GET
- **Purpose:** Change user profile
- **Access:** Authenticated users only
- **Middleware:** `redirectToUserLogin`, `role:user`

#### Booking History
```php
Route::get('/book/history_booking', \App\Livewire\User\HistoryBooking::class)->name('user.history_booking');
```
- **Method:** GET
- **Purpose:** View booking history
- **Access:** Authenticated users only
- **Middleware:** `redirectToUserLogin`, `role:user`

#### Reschedule/Cancel
```php
Route::get('/book/schedule/{uuid}', \App\Livewire\User\RescheduleorCancel::class)->name('user.reschedule_or_cancel');
```
- **Method:** GET
- **Purpose:** Reschedule or cancel booking
- **Access:** Authenticated users only
- **Parameters:** `uuid` - Booking UUID
- **Middleware:** `redirectToUserLogin`, `role:user`

### Admin Routes (Protected)

#### Admin Dashboard
```php
Route::get('/admin/dashboard', \App\Livewire\Admin\Dashboard::class)->name('admin.dashboard');
```
- **Method:** GET
- **Purpose:** Admin dashboard
- **Access:** Admin users only
- **Middleware:** `auth`, `role:admin`

#### Admin Booking Management
```php
Route::get('/admin/booking', \App\Livewire\Admin\Booking::class)->name('admin.booking');
```
- **Method:** GET
- **Purpose:** Manage bookings
- **Access:** Admin users only
- **Middleware:** `auth`, `role:admin`

#### Admin Schedule Management
```php
Route::get('/admin/schedule', \App\Livewire\Admin\Schedule::class)->name('admin.schedule');
```
- **Method:** GET
- **Purpose:** Manage schedules
- **Access:** Admin users only
- **Middleware:** `auth`, `role:admin`

#### Admin Service Management
```php
Route::get('/admin/service', \App\Livewire\Admin\Service::class)->name('admin.service');
```
- **Method:** GET
- **Purpose:** Manage services
- **Access:** Admin users only
- **Middleware:** `auth`, `role:admin`

#### Admin Settings
```php
Route::get('/admin/setting', \App\Livewire\Admin\Setting::class)->name('admin.setting');
```
- **Method:** GET
- **Purpose:** Manage application settings
- **Access:** Admin users only
- **Middleware:** `auth`, `role:admin`

#### Admin User Management
```php
Route::get('/admin/users', \App\Livewire\Admin\Users::class)->name('admin.users');
Route::get('/admin/users/{type}', \App\Livewire\Admin\Users::class)->name('admin.users.type');
```
- **Method:** GET
- **Purpose:** Manage users
- **Access:** Admin users only
- **Parameters:** `type` (optional) - User type filter
- **Middleware:** `auth`, `role:admin`

### PDF Routes

#### PDF Generation
```php
Route::get('/pdf', [BookingComplete::class, 'createPDF'])->name('pdf.test');
Route::get('/pdf_view', [BookingInvoice::class, 'show'])->name('pdf.test_view');
```
- **Method:** GET
- **Purpose:** Generate and view PDFs
- **Access:** Public (for testing)

---

## Authentication & Authorization

### User Roles

#### Admin Role
- Access to admin dashboard
- Manage bookings, schedules, services
- Manage users and settings
- View all system data

#### User Role
- Access to booking system
- View own booking history
- Reschedule/cancel own bookings
- Submit reviews

### Middleware

#### `auth`
Ensures user is authenticated.

#### `role:admin`
Restricts access to admin users only.

#### `role:user`
Restricts access to regular users only.

#### `redirectToUserLogin`
Redirects unauthenticated users to login page.

#### `throttle:20,1`
Rate limiting: 20 requests per minute.

---

## PDF Generation

### Booking Confirmation PDF

**Controller:** `BookingComplete`

**Features:**
- Professional booking confirmation document
- Includes all booking details
- Business branding and contact information
- Automatic file naming with date and UUID
- Document tracking in database

**Generated Content:**
- Client information
- Booking date and time
- Selected services
- Pricing details
- Reschedule token
- Business contact information

**File Naming Convention:**
```
OMN_Appointment_Confirmation_{DATE}_{UUID}.pdf
```

**Example:**
```
OMN_Appointment_Confirmation_25-12-2023_ABC123DEF456.pdf
```

---

## Usage Examples

### Creating a New Booking

```php
// 1. Generate booking code
$bookingCode = generateBookingCode();

// 2. Generate UUID
$uuid = generateUUID();

// 3. Create booking record
$booking = new TBooking();
$booking->code_booking = $bookingCode;
$booking->uuid = $uuid;
$booking->user_id = Auth::id();
$booking->t_schedule_id = $scheduleId;
$booking->t_d_schedule_id = $timeSlotId;
$booking->qty_people_booking = $quantity;
$booking->deposit_price_booking = $deposit;
$booking->save();

// 4. Generate PDF confirmation
$pdfPath = BookingComplete::createPDF($booking->id);
```

### Retrieving User Bookings

```php
// Get user's booking history
$bookings = TBooking::where('user_id', Auth::id())
    ->with(['client', 'detailService.service', 'scheduleDateBook', 'scheduleTimeBook'])
    ->orderBy('id', 'DESC')
    ->get();

foreach ($bookings as $booking) {
    echo "Booking Code: " . $booking->code_booking;
    echo "Date: " . $booking->scheduleDateBook->date_schedule;
    echo "Time: " . $booking->scheduleTimeBook->time;
    echo "Client: " . $booking->client->name;
}
```

### Getting Application Settings

```php
// Get business contact information
$email = getSettingWeb('PaymentEmail');
$address = getSettingWeb('Address');
$instagram = getSettingWeb('Instagram');

// Use in notifications or displays
$contactInfo = [
    'email' => $email,
    'address' => $address,
    'social' => $instagram
];
```

---

## Error Handling

### Common Error Scenarios

1. **Invalid Booking ID**
   - Check if booking exists before generating PDF
   - Handle gracefully with user-friendly messages

2. **Missing Settings**
   - Verify settings exist before retrieving
   - Provide default values when necessary

3. **Authentication Failures**
   - Redirect to login page
   - Show appropriate error messages

4. **Rate Limiting**
   - Inform users of rate limits
   - Provide retry information

---

## Security Considerations

1. **Authentication Required**
   - All user and admin routes require authentication
   - Role-based access control implemented

2. **Rate Limiting**
   - Booking form has rate limiting to prevent abuse
   - 20 requests per minute limit

3. **Input Validation**
   - All user inputs are validated
   - SQL injection protection through Eloquent ORM

4. **File Security**
   - PDF files stored in controlled directory
   - Document generation tracked in database

---

This documentation covers all public APIs, functions, and components in the application. For additional information or specific implementation details, refer to the source code or contact the development team.