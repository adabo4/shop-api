# Vitalis Shop – Requirements

**Project:** Vitalis Shop  
**Document type:** Software Requirements Specification  
**Status:** Living document / Source of Truth  
**Version:** 0.1  
**Last updated:** 25 October 2026

---

# 1. Purpose

Vitalis Shop is an e-commerce platform initially developed for **Lekáreň Vitalis**.

The system should provide a maintainable and scalable foundation for managing:

- customers,
- administrative users,
- authentication,
- roles and permissions,
- products,
- product categories,
- and later orders, payments, shipping and other e-commerce functionality.

The architecture should allow the core e-commerce functionality to be reused in the future for other types of online stores.

This document defines the expected behaviour of the system and serves as the **single source of truth for functional requirements**.

Implementation details may evolve, but changes to expected system behaviour should also be reflected in this document.

---

# 2. Current Scope

The current development phase covers:

1. Authentication
2. Users
3. Roles and permissions
4. Products
5. Categories

Future modules will include:

- shopping cart,
- checkout,
- orders,
- payments,
- shipping,
- invoicing,
- product images,
- inventory,
- administration interface.

These future modules are currently outside the scope of this version of the requirements.

---

# 3. User Types

The system currently distinguishes the following roles:

## 3.1 Customer

A standard registered user of the e-commerce application.

A Customer can use customer-facing functionality but must not have access to administrative product management.

Default role after public registration:

`customer`

---

## 3.2 Product Manager

Role identifier:

`product-manager`

The Product Manager is responsible for managing products.

The Product Manager can:

- view products,
- create products,
- update products,
- delete products.

The Product Manager currently **cannot manage categories**.

This restriction is intentional in the current version and may be changed later.

---

## 3.3 Admin

Role identifier:

`admin`

The Admin has broader administrative access.

The Admin can manage:

- products,
- categories,
- users and their roles.

Additional administrative permissions may be introduced as new modules are implemented.

---

## 3.4 Super Admin

Role identifier: `super-admin`

The Super Admin has unrestricted access to all application permissions.

The Super Admin can:

- manage products and categories,
- manage users and their roles,
- assign or revoke administrative roles,
- access all administrative functionality,
- manage future modules such as orders, payments and shipping.

# 4. Authentication

The API uses Laravel Sanctum with **session-based authentication** for the web application.

Authentication must use secure HTTP-only session cookies rather than exposing authentication tokens to the frontend application.

The frontend must first obtain CSRF protection through:

`GET /sanctum/csrf-cookie`

Requests requiring authentication must use credentials and the appropriate XSRF token.

---

# 5. Registration

## AUTH-001 – Customer registration

The system shall allow a new customer to create an account.

Endpoint:

`POST /api/auth/register`

Required information:

- first name,
- last name,
- email,
- password.

Optional information:

- phone number.

The email address must be unique.

Passwords must never be stored as plain text.

After successful registration:

- a new User shall be created,
- the password shall be hashed,
- the user shall receive the default `customer` role,
- the user shall become authenticated.

Expected successful response:

`201 Created`

---

# 6. Login

## AUTH-002 – User login

The system shall allow an existing user to authenticate using:

- email,
- password.

Endpoint:

`POST /api/auth/login`

After successful authentication, the application shall create an authenticated session.

Expected successful response:

`200 OK`

Invalid credentials must not create an authenticated session.

---

## AUTH-003 – Login rate limiting

The login endpoint shall be rate limited.

The purpose of rate limiting is to reduce repeated password guessing and brute-force login attempts.

When the configured limit is exceeded, the API shall return:

`429 Too Many Requests`

---

# 7. Current User

## AUTH-004 – Retrieve authenticated user

An authenticated user shall be able to retrieve information about their own account.

Endpoint:

`GET /api/auth/me`

The endpoint must only be accessible to authenticated users.

Unauthenticated requests shall return:

`401 Unauthorized`

---

# 8. Logout

## AUTH-005 – Logout

An authenticated user shall be able to terminate their current session.

Endpoint:

`POST /api/auth/logout`

After logout:

- the current session shall be invalidated,
- the session token shall be regenerated,
- protected endpoints must no longer be accessible using the terminated session.

A subsequent request to:

`GET /api/auth/me`

shall return:

`401 Unauthorized`

until the user authenticates again.

---

# 9. Password Reset

## AUTH-006 – Forgotten password

The system shall provide a password reset mechanism.

A user who has forgotten their password shall be able to request a password reset using their email address.

The password reset mechanism must not reveal whether an arbitrary email address belongs to an existing account.

A valid password reset shall allow the user to define a new password.

---

# 10. Users

The User entity currently contains:

- `id`
- `first_name`
- `last_name`
- `email`
- `phone`
- `password`
- timestamps

## USER-001 – Unique email

Each user must have a unique email address.

---

## USER-002 – Password security

User passwords must be stored using secure password hashing.

Plain-text passwords must never be persisted in the database.

---

## USER-003 – Default customer role

Users registering through the public registration endpoint must receive the `customer` role.

Public registration must not allow a user to select an administrative role.

A user must therefore not be able to register themselves as:

- Admin,
- Product Manager,
- or any future privileged role.

---

# 11. Role Management

Administrative roles are assigned separately from public customer registration.

## ROLE-001 – Assign role

An authorized administrator shall be able to assign a role to an existing user.

Example workflow:

1. User account exists.
2. Administrator opens user management.
3. Administrator selects the user.
4. Administrator assigns the appropriate role.
5. The user's permissions change according to the assigned role.

---

## ROLE-002 – Role-based authorization

The backend must enforce authorization.

Hiding buttons or pages in the frontend is not sufficient security.

If a user attempts an operation for which they do not have permission, the API shall reject the request.

Expected response:

`403 Forbidden`

---

## ROLE-003 – Super Admin authorization

The system shall grant the Super Admin all permissions through the authorization layer.

The Super Admin shall not need individual permissions assigned manually.

## ROLE-004 – Super Admin protection

Public registration must never allow users to obtain the super-admin role.

The creation and assignment of Super Admin accounts must be restricted to a trusted administrative process.

Status: DECIDED — protection details to be finalized.

# 12. Permissions

Permissions should describe individual actions rather than being hard-coded directly into role checks.

Current product permissions:

- `products.view`
- `products.create`
- `products.update`
- `products.delete`

Current category permissions:

- `categories.view`
- `categories.create`
- `categories.update`
- `categories.delete`

Roles receive permissions according to their responsibilities.

Current authorization model:

| Action               | Customer | Product Manager | Admin | Super Admin |
| -------------------- | -------- | --------------- | ----- | ----------- |
| View public products | Yes      | Yes             | Yes   | Yes         |
| Create product       | No       | Yes             | Yes   | Yes         |
| Update product       | No       | Yes             | Yes   | Yes         |
| Delete product       | No       | Yes             | Yes   | Yes         |
| View categories      | Yes      | Yes             | Yes   | Yes         |
| Create category      | No       | No              | Yes   | Yes         |
| Update category      | No       | No              | Yes   | Yes         |
| Delete category      | No       | No              | Yes   | Yes         |
| Manage user roles    | No       | No              | Yes   | Yes         |
| Assign Admin role    | No       | No              | TBD   | Yes         |
| Assign Super Admin   | No       | No              | No    | Restricted  |

This permission model represents the current design and may be extended later.

---

# 13. Products

Products represent items available in the product catalogue.

The Product entity currently contains:

- `id`
- `product_code`
- `name`
- `slug`
- `ean`
- `sukl_code`
- `product_type`
- `is_active`
- `description`
- `composition`
- `dosage`
- `usage`
- `warnings`
- timestamps

Price is intentionally **not currently part of the Product entity**.

Commercial/pricing functionality will be designed separately.

---

# 14. Product Code

## PRODUCT-001 – Product code generation

Every product shall have a unique internal product code.

The product code shall be generated automatically by the system.

Format:

`VIT-XXXXXX`

Example:

`VIT-000007`

The user should not need to manually create the product code.

---

# 15. Product Name

## PRODUCT-002 – Product name

Every product must have a name.

The name is required when creating a product.

The product name may later be changed.

---

# 16. Product Slug

## PRODUCT-003 – Automatic slug

Every product shall have a unique slug suitable for URLs.

Example:

Product:

`Nasivin Soft 0.5%`

Slug:

`nasivin-soft-05`

The slug shall be generated automatically from the product name.

The slug must be unique.

---

# 17. Product EAN

## PRODUCT-004 – EAN

A product may contain an EAN identifier.

EAN is optional.

If an EAN is provided, it must be unique within the product database.

---

# 18. ŠÚKL Code

## PRODUCT-005 – ŠÚKL code

A product may contain a ŠÚKL code.

The value is optional because not every type of product requires one.

---

# 19. Product Type

## PRODUCT-006 – Product type

Every product shall have a defined product type.

Current supported values:

`human_medicine`

`food_supplement`

The list may be extended when additional product types are introduced.

---

# 20. Product Active Status

## PRODUCT-007 – Active state

Every product shall contain:

`is_active`

This field represents whether the product is currently active in the catalogue.

A product may remain stored in the database even when it is no longer actively sold.

Setting:

`is_active = false`

must therefore not delete the product.

Administrative API requests may retrieve both active and inactive products.

Customer-facing storefront behaviour regarding inactive products will be defined separately.

---

# 21. Product Information

The product may contain the following optional informational fields:

- description,
- composition,
- dosage,
- usage,
- warnings.

These fields may be updated after product creation.

---

# 22. Product API

Current product operations:

## PRODUCT-008 – List products

`GET /api/products`

The system shall return products stored in the catalogue.

Administrative product retrieval should allow both active and inactive products to be visible.

---

## PRODUCT-009 – Product detail

`GET /api/products/{slug}`

The public-facing product detail is identified using the product slug.

If the product does not exist, the API shall return:

`404 Not Found`

---

## PRODUCT-010 – Create product

`POST /api/products`

Only a user with the appropriate permission may create a product.

The system shall automatically generate fields such as:

- product code,
- slug.

---

## PRODUCT-011 – Update product

`PATCH /api/products/{product}`

Product updates currently use the internal product ID through Laravel route model binding.

Only fields included in the request shall be modified.

Fields that are not included must remain unchanged.

Only an authorized user may update a product.

---

## PRODUCT-012 – Delete product

`DELETE /api/products/{product}`

The product is identified internally by its ID.

Only an authorized user may delete a product.

If the product does not exist:

`404 Not Found`

shall be returned.

---

# 23. Categories

Products may belong to one or more categories.

Categories use a hierarchical tree structure.

The Category entity currently contains:

- `id`
- `parent_id`
- `name`
- `slug`
- timestamps.

---

# 24. Category Hierarchy

## CATEGORY-001 – Parent category

A category may have another category as its parent.

A root category has:

`parent_id = null`

Example:

`Zdravie a lieky`

---

## CATEGORY-002 – Subcategories

A category may contain subcategories.

Example hierarchy:

`Zdravie a lieky`

→ `Bolesť`

→ `Bolesť hlavy`

The hierarchy may contain more than two levels.

The same parent-child mechanism shall therefore support:

- categories,
- subcategories,
- sub-subcategories,
- deeper category structures if needed.

---

# 25. Category Slug

## CATEGORY-003 – Category slug

Every category shall have a unique slug.

Example:

`Zdravie a lieky`

→

`zdravie-a-lieky`

The slug is used as a stable URL-friendly identifier.

---

# 26. Product ↔ Category Relationship

Products and categories have a many-to-many relationship.

A product may belong to multiple categories.

A category may contain multiple products.

The relationship is stored using the pivot table:

`category_product`

Duplicate Product ↔ Category relationships must not be allowed.

---

# 27. Category API

The category API shall support:

- list categories,
- retrieve category,
- create category,
- update category,
- delete category.

Administrative modification operations require appropriate category permissions.

---

# 28. Category Deletion Protection

## CATEGORY-004 – Protect parent categories

A category that contains child categories must not be deleted.

Example:

If:

`Zdravie a lieky`

contains:

`Bolesť`

then `Zdravie a lieky` cannot be deleted until its child category relationship has been resolved.

The API shall return:

`409 Conflict`

with an appropriate error message.

---

# 29. API Error Behaviour

The API should return predictable JSON responses.

Important status codes currently include:

| Status | Meaning                                    |
| ------ | ------------------------------------------ |
| 200    | Successful request                         |
| 201    | Resource created                           |
| 401    | Authentication required                    |
| 403    | Authenticated but insufficient permission  |
| 404    | Resource not found                         |
| 409    | Conflict with existing relationships/state |
| 422    | Validation error                           |
| 429    | Rate limit exceeded                        |

API errors should use understandable JSON messages where appropriate.

Example:

`{ "message": "Product not found." }`

---

# 30. API Documentation

The backend API shall be documented using OpenAPI/Swagger.

Current documentation covers:

- authentication,
- products,
- categories.

Swagger definitions should describe:

- endpoints,
- request bodies,
- validation requirements,
- response codes,
- response schemas.

Swagger documents the API interface, while this Requirements document defines the expected business behaviour.

---

# 31. Automated Tests

Authentication functionality shall be covered by Laravel Feature Tests.

Current authentication tests cover:

- registration,
- login,
- retrieving the authenticated user,
- logout,
- access after logout.

Authorization tests should be added for roles and permissions.

Future tests should verify that unauthorized users cannot perform privileged product/category operations.

---

# 32. Security Requirements

The application shall follow these baseline security requirements:

- passwords must be hashed,
- authentication must use secure sessions,
- CSRF protection must be enabled,
- login must be rate limited,
- backend authorization must protect privileged operations,
- public registration must not allow privilege escalation,
- validation must be performed on the backend,
- sensitive operations must not rely solely on frontend restrictions.

---

# 33. Current Business Rules

The following decisions are considered part of the current system design:

**BR-001**  
A newly registered public user is a Customer.

**BR-002**  
A Customer cannot assign themselves an administrative role.

**BR-003**  
Product Manager manages products.

**BR-004**  
Product Manager currently does not manage categories.

**BR-005**  
Admin manages products and categories.

**BR-006**  
Admin can manage user roles.

**BR-007**  
Inactive products remain stored in the database.

**BR-008**  
Products can belong to multiple categories.

**BR-009**  
Categories may have an arbitrary hierarchical depth.

**BR-010**  
A category containing child categories cannot be deleted.

**BR-011**  
Product code is generated automatically.

**BR-012**  
Product slug is generated automatically.

**BR-013**  
EAN is optional but unique when present.

**BR-014**  
Product pricing is currently outside the Product model and will be designed as part of the commercial layer.

Additional Business Rules

**BR-015**
The Super Admin has all application permissions.

**BR-016**
The Super Admin role cannot be obtained through public registration.

**BR-017**
Regular administrators must not be able to assign the Super Admin role.

**BR-018**
Super Admin authorization is enforced on the backend, independently of frontend controls.

---

# 34. Open Decisions

The following areas have not yet been finalized and must not be treated as implemented requirements:

- exact admin-panel user creation/invitation workflow,
- whether Product Managers will later manage categories,
- product pricing architecture,
- inventory/stock architecture,
- product image architecture,
- cart architecture,
- checkout,
- order lifecycle,
- payment providers,
- shipping providers,
- invoice generation,
- customer addresses,
- guest checkout,
- email verification,
- account deletion,
- soft-delete strategy for products,
- audit log of administrative changes.

When a decision is made, it should be moved from this section into the appropriate requirements section.

---

# 35. Planned Modules

Future versions of this document should introduce dedicated sections for:

## Products – Phase 2

- product images,
- pricing,
- availability,
- inventory,
- variants if required,
- product import.

## Customers

- profile management,
- addresses,
- order history.

## Cart

- cart items,
- quantities,
- totals.

## Orders

- order creation,
- statuses,
- order items,
- order history.

## Checkout

- customer information,
- shipping address,
- billing information,
- payment selection,
- shipping selection.

## Payments

Potential providers:

- GoPay,
- Stripe,
- Google Pay,
- Apple Pay,
- Mastercard-supported payment flows.

Final providers and architecture are not yet decided.

## Shipping

Potential providers:

- Packeta,
- GLS,
- SPS.

Final providers and architecture are not yet decided.

## Administration

- dashboard,
- product management,
- category management,
- user management,
- role management,
- order management.

---

# 36. Requirement Status Convention

From the next revision, requirements should use the following statuses:

**IMPLEMENTED** – functionality exists and has been implemented.

**TESTED** – functionality exists and is covered by automated or verified manual tests.

**DECIDED** – architecture/business behaviour has been agreed upon but may not yet be implemented.

**PLANNED** – functionality is intended but detailed requirements have not yet been finalized.

**OPEN** – decision is still required.

Example:

`AUTH-001 | TESTED | Customer registration`

`ROLE-002 | IMPLEMENTED | Role-based authorization`

`ORDER-001 | PLANNED | Create order`

This makes the Requirements document useful not only as documentation, but also as a high-level overview of project progress.

---

# 37. Change Management

This file is the functional Source of Truth for Vitalis Shop.

Whenever a significant business rule or system behaviour changes:

1. Decide the desired behaviour.
2. Update this Requirements document.
3. Update the implementation.
4. Update Swagger/OpenAPI if the API contract changed.
5. Add or update automated tests.

A feature should not be considered fully finished when the implementation contradicts the current requirements.

---

# 38. Document History

| Version | Date        | Description                                                                             |
| ------- | ----------- | --------------------------------------------------------------------------------------- |
| 0.1     | 25 Oct 2026 | Initial requirements covering Auth, Users, Roles & Permissions, Products and Categories |
