<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Barangay Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">   
<style>
    
    /* Global reset — removes default margin, padding, and box model issues */
    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    /* Body — sets the default font and background color */
    body {
        font-family: 'DM Sans', sans-serif;
        background: #f5f5f5;
    }

    /* Navbar — the top navigation bar */
    .top-navbar {
        background: #ffffff;
        border-bottom: 1px solid #e5e5e5;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    /* Navbar inner — flex container that holds all navbar items */
    .top-navbar-inner {
        display: flex;
        align-items: center;
        height: 60px;
        padding: 0 24px;
    }

    /* Brand — the logo and name on the left side of the navbar */
    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-right: 24px;
        border-right: 1px solid #e5e5e5;
        text-decoration: none;
        flex-shrink: 0;
    }

    /* Brand name — the text next to the logo */
    .brand-name {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        white-space: nowrap;
    }

    /* Nav links — the list of navigation items */
    .nav-links {
        display: flex;
        align-items: center;
        list-style: none;
        overflow: visible;
        scrollbar-width: none;
        flex: 1;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Nav links scrollbar — hides the scrollbar on webkit browsers */
    .nav-links::-webkit-scrollbar {
        display: none;
    }

    /* Nav links item — each individual navigation link */
    .nav-links li a {
        display: block;
        padding: 0 10px;
        height: 60px;
        line-height: 60px;
        font-size: 13px;
        font-weight: 600;
        color: #555555;
        text-decoration: none;
        white-space: nowrap;
        border-bottom: none;
        transition: color 150ms ease, transform 150ms ease;
    }

    /* Nav links hover — highlight when hovering over a nav item */
    .nav-links li a:hover {
        color: #555;
        background: #e5e5e5;
        border-radius: 5px;
    }

    /* Nav links active — highlight the currently selected nav item */
    .nav-links li a.active {
        color: #1a3a5c;
    }

    /* Nav item — position relative so dropdown is placed below it */
    .nav-item {
        position: relative;
    }

    /* Dropdown — hidden menu that appears when hovering over a nav item */
    .nav-dropdown {
        display: none;
        position: absolute;
        top: 60px;
        left: 0;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        min-width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 99;
        padding: 6px 0;
        margin-top: 0;
    }

    /* Dropdown links — each item inside the dropdown */
    .nav-dropdown a {
        display: block;
        padding: 10px 16px;
        font-size: 13px;
        color: #444;
        text-decoration: none;
        font-weight: 400;
        transition: background 150ms ease;
    }

    /* Dropdown links hover — highlight when hovering over a dropdown item */
    .nav-dropdown a:hover {
        background: #f5f5f5;
        color: #1a1a1a;
    }

    /* Dropdown show — shows the dropdown when hovering over the nav item */
    .nav-item:hover .nav-dropdown {
        display: block;
    }

    /* Footer — sticky bar at the bottom of the page */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        background: #ffffff;
        border-top: 1px solid #e5e5e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #888;
        z-index: 100;
    }
    
    .footer p {
        margin: 0;
    }
    /* Page content — padding around the main content area */
    .page-content {
        padding: 32px 24px;
    }

    /* Barangay logo — centered watermark logo in the background */
    .Barangay-logo {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 800px;
        position: fixed;
        top: 60px;
        left: 0;
        right: 0;
        z-index: -10;
    }

    /* Barangay logo image — faded watermark effect */
    .Barangay-logo img {
        opacity: 0.3;
        width: 500px;
    }

    /* Settings menu — container for the settings button and dropdown */
    .settings-menu {
        position: relative;
        margin-left: auto;
        flex-shrink: 0;
    }

    /* Settings button — the gear icon button */
    .settings-btn {
        background: none;
        border: 1px solid #e5e5e5;
        border-radius: 7px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 150ms ease;
    }

    /* Settings button hover — highlight when hovering over the settings button */
    .settings-btn:hover {
        background: #e5e5e5;
    }

    /* Settings button icon — the gear icon size */
    .settings-btn svg {
        width: 18px;
        height: 18px;
        stroke: #555;
    }

    /* Settings dropdown — hidden menu that appears when clicking the settings button */
    .settings-dropdown {
        display: none;
        position: absolute;
        top: 48px;
        right: 0;
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 8px;
        min-width: 180px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 999;
        padding: 6px 0;
    }

    /* Settings dropdown open — shows the dropdown when clicking the settings button */
    .settings-dropdown.open {
        display: block;
    }

    /* Settings dropdown links — each item inside the settings dropdown */
    .settings-dropdown a {
        display: block;
        padding: 10px 16px;
        font-size: 13.5px;
        color: #555;
        text-decoration: none;
        transition: background 150ms ease;
    }

    /* Settings dropdown links hover — highlight when hovering over a settings item */
    .settings-dropdown a:hover {
        background: #f5f5f5;
        color: #555;
    }

    /* Settings dropdown divider — horizontal line separating items */
    .settings-dropdown hr {
        border: none;
        border-top: 1px solid #e5e5e5;
        margin: 4px 0;
    }








</style>

    @yield('styles')

</head>
<body>

<nav class="top-navbar">
  <div class="top-navbar-inner">
    <img src="/BarangayNewEra.png" style="width: 35px; height: 35px; border-radius: 50%; margin: 5px;">
    <a class="brand" href="{{ route('dashboard') }}">
      <span class="brand-name">Barangay Management</span>
    </a>

    {{-- Resident Management --}}
    <ul class="nav-links">
      <li class="nav-item">
        <a href="{{ route('residents.index') }}" class="{{ request()->routeIs('residents.*') ? 'active' : '' }}">Resident Management</a>
        <div class="nav-dropdown">
            <a href="{{ route('residents.add') }}">Add Resident</a>
            <a href="#">Archived Residents</a>
        </div>
      </li>

      {{-- Document Management --}}
      <li class="nav-item">
        <a href="{{ route('documents.index') }}"  class="{{ request()->routeIs('documents.*')  ? 'active' : '' }}">Document Issuance</a>
        <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
      </li>

      {{-- Blotter --}}
      <li class="nav-item"><a href="{{ route('blotter.index') }}"    class="{{ request()->routeIs('blotter.*')    ? 'active' : '' }}">Blotter Management</a>
        <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
        </li>
        
      {{-- Household Management --}}
      <li class="nav-item"><a href="{{ route('household.purok-index') }}"  class="{{ request()->routeIs('purok.*')  ? 'active' : '' }}">Household & Purok</a>
    <div class="nav-dropdown">
            <a href="{{ route('household.purok-index') }}">Purok</a>
            <a href="{{ route('household.household-index') }}">Households</a>
        </div>
    </li>

      {{-- Business --}}
      <li class="nav-item"><a href="{{ route('business.index') }}"   class="{{ request()->routeIs('business.*')   ? 'active' : '' }}">Business Permit</a>
    <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>

      {{-- Officials --}}
      <li class="nav-item"><a href="{{ route('officials.index') }}"  class="{{ request()->routeIs('officials.*')  ? 'active' : '' }}">Officials & Staff</a>
      <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>

      {{-- Commitee Management --}}
      <li class="nav-item"><a href="{{ route('committee.index') }}"  class="{{ request()->routeIs('committee.*')  ? 'active' : '' }}">Committee Management</a>
    <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>

      {{-- Reporst --}}
      <li class="nav-item"><a href="{{ route('reports.index') }}"    class="{{ request()->routeIs('reports.*')    ? 'active' : '' }}">Reports & Analytics</a>
    <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>

      {{-- User Management --}}
      <li class="nav-item"><a href="{{ route('users.index') }}"      class="{{ request()->routeIs('users.*')      ? 'active' : '' }}">User Management</a>
    <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>

      {{-- Tech --}}
      <li class="nav-item"><a href="{{ route('technical.index') }}"  class="{{ request()->routeIs('technical.*')  ? 'active' : '' }}">Technical Specs</a>
    <div class="nav-dropdown">
            <a href="#">Add Resident</a>
            <a href="#">View Residents</a>
        </div>
    </li>
    
    </ul>

    <div class="settings-menu">
        <button class="settings-btn" onclick="toggleSettings()">
            <i class="fa-solid fa-gear"></i>
        </button>

        <div class="settings-dropdown" id="settingsDropdown">
            <a href="#">Profile</a>
            <a href="#">Account Settings</a>
            <a href="#">Help</a>
            <hr>
            <a href="#" style="color: #e53e3e;">Logout</a>
        </div>
    </div>

  </div>
</nav>

<div class="page-content">

    <div class="Barangay-logo">
        <img src="/BarangayNewEra.png">
    </div>

    @yield('content')
</div>

<div class="footer">
    <p>© 2025 Barangay New Era, District VI, Quezon City. All Rights Reserved.</p>
</div>

<script>
    function toggleSettings() {
        document.getElementById('settingsDropdown').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const menu = document.querySelector('.settings-menu');
        if (!menu.contains(e.target)) {
            document.getElementById('settingsDropdown').classList.remove('open');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>