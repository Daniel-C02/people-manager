
// --------------------------------------------------------------------------------------
// ✅ Import Project SCSS Styles
// --------------------------------------------------------------------------------------
import('@scss/app.scss');

// --------------------------------------------------------------------------------------
//   Import Bootstrap (JavaScript Bundle)
// --------------------------------------------------------------------------------------
// Bootstrap provides responsive, mobile-first components and interactions via its JavaScript library.
// The 'bootstrap.bundle' includes Popper for tooltips, popovers, dropdowns, and other interactive components.
import * as bootstrap from 'bootstrap/dist/js/bootstrap.bundle';
window.bootstrap = bootstrap; // Make Bootstrap globally accessible via 'window.bootstrap'


// --------------------------------------------------------------------------------------
//   Import International Telephone Input (JavaScript Bundle)
// --------------------------------------------------------------------------------------
import 'intl-tel-input/build/css/intlTelInput.css';
import intlTelInput from 'intl-tel-input';
window.intlTelInput = intlTelInput;


// --------------------------------------------------------------------------------------
//   Import Flatpickr (JavaScript Bundle)
// --------------------------------------------------------------------------------------
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import 'flatpickr/dist/themes/dark.css';
window.flatpickr = flatpickr;


// --------------------------------------------------------------------------------------
//   Import Tom Select (JavaScript Bundle)
// --------------------------------------------------------------------------------------
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.bootstrap5.min.css';
window.TomSelect = TomSelect;


// --------------------------------------------------------------------------------------
//   Importing JavaScript files responsible for CSS animations and visual effects
// --------------------------------------------------------------------------------------
// Contains modules handling animations like fade-ins, slide transitions, scroll-triggered animations, etc.
// Helps to maintain smooth and responsive user interactions throughout the application.
// import './animations';


// --------------------------------------------------------------------------------------
//   Importing External Libraries or Plugins
// --------------------------------------------------------------------------------------
// Loads and initializes third-party libraries (e.g., Bootstrap JS, SplideJS, SweetAlert2, etc.).
// Centralized management of external dependencies, allowing for easy maintenance and upgrades.
// import './plugins';


// --------------------------------------------------------------------------------------
//   Importing Custom Modular Scripts
// --------------------------------------------------------------------------------------
// Contains JavaScript files dedicated to various reusable UI components or features.
// Examples include: Navbar interactions, Footer behavior, Modal handling, Sliders, etc.
// Promotes a clean, modular approach to organizing scripts related to individual UI elements.
import './modules';


// --------------------------------------------------------------------------------------
//   Importing Page-Specific JavaScript
// --------------------------------------------------------------------------------------
// Organizes scripts unique to specific pages or sections (e.g., Home, About, Contact).
// Keeps page-specific logic isolated, making the application structure more maintainable and scalable.
// import './pages';


// --------------------------------------------------------------------------------------
//   Other
// --------------------------------------------------------------------------------------
//
// ** utilities **
// Utilities Directory: Contains reusable helper functions and general-purpose scripts used
// throughout the application (e.g., formatters, validators, API handlers).
//
// ** mock **
// Mock Directory: Stores placeholder data and testing utilities for development purposes,
// enabling the simulation of API responses and frontend interactions.

// --------------------------------------------------------------------------------------
//   Main Message
// --------------------------------------------------------------------------------------
//
// Designed & Developed by CubeZoo
// PEOPLE. DIGITAL. SIMPLIFIED
console.log(
    `%cDesigned & Developed by Daniel Christensen`,
    'color: #94a3b8; font-size: 16px; font-weight: bold; margin-bottom: 4px;',
);
//
// Tech Stack
//     Laravel: The PHP Framework for Web Artisans
//     HTML: Standard Markup Language for Web Pages
//     JavaScript: The Language of the Web
//     SCSS: CSS with Superpowers
console.groupCollapsed('%c Tech Stack',                    'color: #94a3b8; font-size: 14px; font-weight: normal;' );
console.log('%cLaravel: %cThe PHP Framework for Web Artisans',  'color: #fb503b; font-weight: bold;', 'color: #f8f8f2;' );
console.log('%cHTML: %cStandard Markup Language for Web Pages', 'color: #e34f26; font-weight: bold;', 'color: #f8f8f2;' );
console.log('%cJavaScript: %cThe Language of the Web',          'color: #f7df1e; font-weight: bold;', 'color: #f8f8f2;' );
console.log('%cSCSS: %cCSS with Superpowers',                   'color: #cf649a; font-weight: bold;', 'color: #f8f8f2;' );
console.groupEnd();
//
// Visit us: https://www.danielchristensen.dev
console.log(
    "%c🔗 Visit me: %chttps://www.danielchristensen.dev",
    'color: #7dd3fc; font-size: 12px; margin-top: 5px;',
    'color: #7dd3fc; font-size: 12px; text-decoration: underline;'
);
