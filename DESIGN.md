# Design System Specification (DESIGN.md)

**Project:** Sistem Presensi (Attendance & Reporting System)  
**Framework:** Laravel (Blade Templates + Modern Vanilla CSS & Tailwind-compatible utilities)  
**Connected Design Tool:** Google Stitch ([stitch.withgoogle.com](https://stitch.withgoogle.com/))

---

## 1. Brand Identity & Theme
- **Application Name:** Sistem Presensi Pegawai / Mahasiswa
- **Style Archetype:** Modern Clean Enterprise & Dashboard UI (Glassmorphism subtle touches, clear card hierarchy, responsive mobile-first attendance flow)
- **Primary Font:** `Plus Jakarta Sans`, sans-serif (`400`, `500`, `600`, `700`, `800`)

---

## 2. Color Palette & Tokens
| Token | Hex Value | Role / Usage |
| :--- | :--- | :--- |
| `--primary` | `#2563eb` | Main brand color, active buttons, active tabs |
| `--primary-hover` | `#1d4ed8` | Interactive hover states |
| `--primary-light` | `#eff6ff` | Badge backgrounds, active nav pill tints |
| `--success` | `#16a34a` | Present / Masuk / Clock-In status |
| `--success-light` | `#dcfce7` | Success badge background |
| `--warning` | `#d97706` | Late / Terlambat status |
| `--warning-light` | `#fef3c7` | Warning badge background |
| `--danger` | `#dc2626` | Absent / Alpha / Clock-out status |
| `--danger-light` | `#fee2e2` | Danger badge background |
| `--info` | `#0284c7` | Permission / Izin status |
| `--purple` | `#7c3aed` | Sick / Sakit status |
| `--dark` | `#0f172a` | Headers, heavy typography, dark accents |
| `--gray-50` | `#f8fafc` | Global canvas / page background |
| `--gray-100` | `#f1f5f9` | Card and section separators |
| `--gray-200` | `#e2e8f0` | Subtle borders, table strokes |
| `--gray-500` | `#64748b` | Muted subheadings, timestamps |
| `--gray-700` | `#334155` | Primary body text |

---

## 3. Elevation & Radius
- **Border Radius:**
  - Buttons / Inputs: `10px` - `12px`
  - Cards / Modals: `16px` - `20px`
  - Badges / Chips: `9999px` (Full pill)
- **Shadows:**
  - Soft Card: `0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05)`
  - Elevated / Hover: `0 10px 15px -3px rgb(0 0 0 / 0.08), 0 4px 6px -4px rgb(0 0 0 / 0.04)`

---

## 4. Key Screens & Target Stitch Prompts
1. **Dashboard & Attendance Hub (`/dashboard`, `/attendances`):**
   - Real-time digital clock with Live Status (Sudah Presensi / Belum Presensi).
   - Quick Clock-in / Clock-out action cards with Geolocation & Camera selfie capture indicator.
   - Summary Metric Counters: Total Hadir, Terlambat, Izin, Sakit, Alpha.
   - Filterable data table with date range picker and export buttons (PDF, CSV).
2. **Report & Analytics Screen (`/reports`):**
   - Monthly calendar grid / heatmap view of employee attendance.
   - Attendance percentage radial chart or bar graphs.
   - Detailed user attendance breakdown modal (`/reports/user/{id}`).
3. **Authentication Screen (`/login`):**
   - Clean split-screen or centered card authentication with secure credentials, remember me, and company branding.

---

## 5. Stitch Integration Workflow
1. Generate or update screens in **[Google Stitch](https://stitch.withgoogle.com/)**.
2. Sync design tokens and HTML structures via the **Stitch MCP Server**.
3. Integrate exported layouts into Laravel Blade templates (`resources/views/...`).
