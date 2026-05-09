# Digital Library System - Quick Start & Testing Guide

## 🚀 Getting Started

### 1. Start the Development Server
```bash
php artisan serve
```
The application will be available at: `http://127.0.0.1:8000`

### 2. Seed Sample Data (Optional)
```bash
php artisan db:seed
```
This creates:
- 1 Admin user (admin@library.com)
- 1 Librarian user (librarian@library.com)
- 6 Sample students with different programs
- 4 Departments (Hotel Management, Business Admin, Education, Computer Science)
- Sample books and borrow records

## 📝 Test Credentials

After seeding, use these credentials:

**Admin Account**
- Email: `admin@library.com`
- Password: `password`
- Role: Admin
- URL: http://127.0.0.1:8000/login

**Librarian Account**
- Email: `librarian@library.com`
- Password: `password`
- Role: Librarian
- URL: http://127.0.0.1:8000/login

**Student Accounts** (auto-created with programs)
- Email: `[student_name@example.com](http://student_name@example.com)`
- Password: `password` (set by factory)
- Role: Student

## ✅ Feature Testing Checklist

### Registration
- [ ] Go to `/register/admin` and create an admin account
- [ ] Go to `/register/student` and create a student account
- [ ] Verify program selection is required for students
- [ ] Verify you can select from: BSHM, BSBA, EDUC, BSCS

### Student Dashboard
- [ ] Login as student
- [ ] Navigate to `/student/dashboard`
- [ ] Verify you see: Active Borrows, Overdue, Returned, Fines Owed stats
- [ ] Check that your program is displayed

### Book Browsing & Borrowing
- [ ] Login as student
- [ ] Go to `/student/books`
- [ ] Search for books by title/author/ISBN
- [ ] Filter books by department
- [ ] Click "Borrow" on an available book
- [ ] Verify book appears in "Active Borrows" on dashboard
- [ ] Check "Available" count decreases

### Book Returns
- [ ] Return a book from the dashboard or books page
- [ ] Verify it moves to "Recent Returns" on dashboard
- [ ] Verify book availability increases

### Fine Calculation
- [ ] Manually create an overdue borrow record in database:
  ```sql
  INSERT INTO borrows (user_id, book_id, borrowed_at, due_at, status, created_at, updated_at)
  VALUES (1, 1, NOW() - INTERVAL 20 DAY, NOW() - INTERVAL 6 DAY, 'active', NOW(), NOW());
  ```
- [ ] Return the book from dashboard
- [ ] Verify fine is calculated: (due_days * $5) where due_days is days overdue
- [ ] Check fine appears on dashboard

### Fine Payment
- [ ] Go to Student Dashboard
- [ ] Look at "Recent Returns" section
- [ ] Click "Pay" button on a fine
- [ ] Verify fine is marked as "✓ Paid"
- [ ] Verify "Unpaid Fines" stat decreases

### Admin Dashboard
- [ ] Login as admin
- [ ] Go to `/admin/dashboard`
- [ ] Verify stats cards show: Users, Books, Borrows, Overdue, Unpaid Fines
- [ ] Check "Recent Borrow Activity" for fine notifications

### Admin User Management
- [ ] Go to `/admin/users`
- [ ] Search by name or email
- [ ] Verify table shows: Name, Role, Program, Borrowed count, Joined date
- [ ] Click "View" to see user details
- [ ] Verify user borrow history shows all borrows

### Admin Book Management
- [ ] Go to `/admin/books`
- [ ] Search by title, author, or ISBN
- [ ] Filter by department
- [ ] Click "Edit" on a book
- [ ] Click "+ Add New Book" to create a book with a department
- [ ] Verify books appear in correct department in inventory

### Department Inventory
- [ ] Go to `/admin/inventory`
- [ ] Verify all departments are listed
- [ ] Check summary stats at top: Departments, Total Books, Available, Borrowed
- [ ] For each department, verify:
  - [ ] Department name and code shown
  - [ ] Books listed with title, author, ISBN
  - [ ] Available/Borrowed/Total columns show correct numbers
  - [ ] Color-coded status badges (green for available, amber for borrowed)

### Student Program Association
- [ ] Check that students have their program displayed
- [ ] Verify in admin panel students show their program
- [ ] In inventory, verify student can access books from all departments

### Navigation & UI
- [ ] Verify sidebar navigation works correctly for each role
- [ ] Check responsive design on mobile (use browser dev tools)
- [ ] Test all color-coded badges display correctly
- [ ] Verify flash messages appear on all operations

### Role-Based Access Control
- [ ] Login as student, try to access `/admin/dashboard` - should get 403
- [ ] Login as librarian, try to access `/admin/books` - should get 403
- [ ] Verify each role only sees their specific navigation items

## 🔧 Useful Artisan Commands

```bash
# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Reset database and seed
php artisan migrate:fresh --seed

# View all routes
php artisan route:list

# Cache configuration
php artisan config:cache

# Clear all caches
php artisan cache:clear
php artisan config:clear
```

## 🐛 Troubleshooting

### Application won't start
- Check `.env` file exists with correct DATABASE_URL
- Run: `php artisan migrate:fresh --seed`
- Check logs: `storage/logs/laravel.log`

### Middleware issues (403 errors)
- Verify `app/Http/Middleware/EnsureRole.php` exists
- Check routes in `routes/web.php` have correct middleware
- Verify user has correct role in database

### Fine calculation not showing
- Ensure due_at is in the past
- Check `calculateFine()` method in `app/Models/Borrow.php`
- Verify fine_amount is calculated when returning

### Database tables not found
- Run: `php artisan migrate:fresh`
- Check migrations in `database/migrations/`

## 📊 Key Test Scenarios

### Scenario 1: Complete Student Workflow
1. Create student account with program selection
2. Browse and borrow books
3. Return book (if early, no fine)
4. Return another book that's overdue
5. Check dashboard for fine
6. Pay fine from dashboard
7. Verify fine shows as paid

### Scenario 2: Admin Monitoring
1. Login as admin
2. View dashboard with current statistics
3. Check overdue books count
4. View specific student's borrow history
5. Check inventory by department
6. Verify all stats are accurate

### Scenario 3: Department Filtering
1. Go to book listing
2. Filter by each department
3. Verify correct books appear
4. Verify book count matches inventory

### Scenario 4: Search Functionality
1. Admin: Search users by partial name/email
2. Admin: Search books by partial title/author
3. Student: Search books in browsing page
4. Verify pagination works with search results

## 📱 Browser Compatibility
- ✅ Chrome/Edge (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Mobile browsers (Responsive design)

## 🎨 UI/UX Testing
- [ ] Dark theme is consistent across all pages
- [ ] Maroon (#8B0000) and Gold accents are visible
- [ ] All buttons are clickable and responsive
- [ ] All tables have proper scrolling on small screens
- [ ] No layout broken on mobile view
- [ ] All icons display correctly
- [ ] Color contrast is readable (accessibility)

## ✨ Performance Tips
- Dashboard loads quickly even with many records
- Search/filter performance is acceptable
- No console errors in browser dev tools
- Images load properly (if any)

---

**All features are complete and ready for testing!**

For detailed implementation information, see: [IMPLEMENTATION_GUIDE.md](IMPLEMENTATION_GUIDE.md)
