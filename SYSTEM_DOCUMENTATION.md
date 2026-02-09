Finda-UK Project Documentation & Working Overview
Project Summary
Finda-UK is a premium real estate management system designed to manage and showcase properties efficiently. The platform supports two types of properties: Standard Listings and Off-Market (Distress) Deals.
Key Working Highlights
•	Properties are added and edited using a structured 3-step process (Basic Information → Features → Media).
•	Admin can control listing statuses: Approved, Rejected, or Pending.
•	All website inquiries are handled through a centralized Message Intelligence Hub.
•	Built using modern, scalable technologies for performance and maintainability.
________________________________________
Core Modules
Property Listings Management
The system manages two categories of property listings:
1.	Standard Listings
Properties publicly available for sale or rent.
2.	Off-Market (Distress) Listings
Exclusive or distressed properties not openly listed in the market.
________________________________________
Inquiry Management (Message Intelligence Hub)
All inquiries submitted through website contact forms are stored in the Admin Dashboard under the Message Intelligence Hub.
Admins can: - View and manage incoming messages - Reply directly from the dashboard - Archive resolved inquiries
________________________________________
Property Listing Form Workflow
Property creation and editing follow a structured 3-step workflow:
Stage 1: Basic Information
This stage captures the primary property details: - Property headline/title - UK-based address selection using Google Places Autocomplete - Purpose: Buy (Sale) or Rent - Property price or rental amount (GBP) - Optional old price for discount display - Ownership type (Freehold / Leasehold) for sale listings - Rent frequency and cheque requirements for rental listings - Property type and unit category - Area size (square feet) - Number of bedrooms and bathrooms - Full property description using CKEditor (rich text editor)
________________________________________
Stage 2: Features & Amenities
Admins can select multiple property features using checkboxes, including: - Swimming Pool - Gym - Parking - High-Speed WiFi - Garden - Other custom amenities
________________________________________
Stage 3: Media & Assets
•	Hero Image (main featured image)
•	Image gallery for slider display
•	Video walkthrough upload (MP4/MOV, recommended maximum size: 20MB)
________________________________________
Database Structure (Listing Model)
Field Name	Type	Description
property_title	String	Property title
description	Text	Detailed HTML description
purpose	Enum	Buy or Rent
price	Decimal	Current asking price
old_price	Decimal	Previous price for discount
address	Text	Full property address
latitude / longitude	Double	Map coordinates
property_type_id	Foreign Key	Property type reference
unit_type_id	Foreign Key	Unit category reference
bedrooms	Integer	Bedroom count
bathrooms	Integer	Bathroom count
thumbnail	String	Main image path
gallery	JSON / Array	Gallery images
video	String	Video path
status	String	pending / approved / rejected
________________________________________
Key Interactive Features
1.	Google Maps Integration
UK-specific address suggestions with automatic geolocation.
2.	Dynamic Multi-Step Interface
Smooth navigation between form steps without page reload.
3.	Admin DataTables
Advanced search, sorting, and filtering in admin panels.
4.	Mortgage Calculator
Interactive calculator available on buy-property detail pages.
________________________________________
Technology Stack
•	Backend: Laravel 10+ (PHP)
•	Frontend: Blade Templating, Tailwind CSS
•	Database: MySQL
•	Text Editor: CKEditor 5
•	Maps & Location Services: Google Places & Geocoding API
•	Icons: BoxIcons

________________________________________
### Brand Identity & Theme
- **Primary Colors**: 
  - Navy (#131B31) - Used for structural elements like the Admin Sidebar and primary text.
  - Purple (#8046F1) - Used for interactive elements, highlights, and active states.
  - Accent Gold (#FCC608) - Used for highlights and special call-to-actions.
- **Typography**: 
  - **Inter**: Primary sans-serif font for readability and layout.
  - **Outfit**: Used for premium headings and brand elements.
- **Design Aesthetic**: Premium modern UI with Glassmorphism, rounded corners (1.5rem), and high-contrast dark modes for admin navigation.
