# DigiLib Admin Panel - Visual Reference Guide

## 🎨 Complete UI Component Reference

### Color Palette Reference
```
Maroon     #8B0000 - Primary color (buttons, highlights)
Gold       #DAA520 - Accent color (special buttons)
Red        #DC2626 - Danger/Error
Amber      #F59E0B - Warning/Active
Green      #10B981 - Success/Available
Blue       #3B82F6 - Info
Purple     #9333EA - Secondary
Cyan       #06B6D4 - Department tags
Gray       #6B7280 - Text/inactive
White      #FFFFFF - Background/text
Black      #000000 - Dark backgrounds
```

---

## 📊 Typography Scale

```
Headings (Page Headers):
  Font-size: 1.125rem (18px)
  Font-weight: 700
  Color: white
  
Section Titles:
  Font-size: 1rem (16px)
  Font-weight: 700
  Color: white

Table Headers:
  Font-size: 0.875rem (14px)
  Font-weight: 600
  Color: #9CA3AF
  Background: rgba(255, 255, 255, 0.05)

Body Text:
  Font-size: 0.875rem (14px)
  Font-weight: 400
  Color: white

Small Text:
  Font-size: 0.75rem (12px)
  Font-weight: 400
  Color: #9CA3AF

Monospace (ISBN, Code):
  Font-family: monospace
  Font-size: 0.875rem (14px)
  Color: #9CA3AF
```

---

## 🧩 Component Styles

### Buttons

#### Primary Button (Search, Browse)
```css
Background: #8B0000
Hover: Darker maroon
Color: white
Padding: 12px 24px
Border-radius: 12px
Font-weight: 500
Transition: all 0.15s
```

#### Gold Button (Add New)
```css
Background: linear-gradient(to right, #DAA520, #B8860B)
Hover: Darker gradient
Color: #111827
Padding: 12px 24px
Border-radius: 12px
Font-weight: 700
Box-shadow: 0 4px 12px rgba(218, 165, 32, 0.3)
```

#### Icon Buttons (View, Edit, Remove)
```css
Background: [color]/20
Color: [color]/300
Padding: 8px 12px
Border-radius: 8px
Font-weight: 500
Transition: all 0.15s

View:   Blue (#3B82F6)
Edit:   Amber (#F59E0B)
Remove: Red (#DC2626)
```

---

### Badges & Tags

#### Role Badge
```css
Admin:
  Icon: 👑
  Background: #7F1D1D/20
  Color: #FCA5A5
  Font-size: 12px
  Font-weight: 600
  Padding: 4px 12px
  Border-radius: 8px

Student:
  Icon: 🧑
  Background: #1E40AF/20
  Color: #93C5FD
  Font-size: 12px
  Font-weight: 600
```

#### Program Badge
```css
Background: #6B21A8/20
Color: #E9D5FF
Font-size: 12px
Font-weight: 500
Padding: 4px 12px
Border-radius: 8px
Example: BSCS, BSHM, BSBA, EDUC
```

#### Status Badge
```css
Green (Available):
  Icon: ✓
  Background: #10B981/20
  Color: #6EE7B7
  Font-weight: 600

Amber (Active):
  Icon: 📌
  Background: #F59E0B/20
  Color: #FBBF24
  Font-weight: 600

Red (Overdue):
  Icon: ⚠️
  Background: #DC2626/20
  Color: #FCA5A5
  Font-weight: 600
```

---

### Cards

#### Stat Card (Summary)
```css
Background: linear-gradient(to bottom right, [color]/20, [color]/5)
Border: 1px solid [color]/20
Hover Border: [color]/40
Border-radius: 16px
Padding: 24px
Display: flex
Justify: space-between
Align: center
Transition: all 0.2s

Maroon Card:  #8B0000 gradients
Blue Card:    #3B82F6 gradients
Green Card:   #10B981 gradients
Amber Card:   #F59E0B gradients
```

#### Data Card (Main Content)
```css
Background: #1F2937
Border: 1px solid rgba(255, 255, 255, 0.1)
Hover Border: rgba(139, 0, 0, 0.3)
Border-radius: 16px
Padding: 24px
Box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1)
Transition: all 0.2s
```

---

### Tables

#### Table Structure
```html
<table>
  <thead class="bg-maroon-900/50 border-b border-white/10">
    <tr class="text-gray-300">
      <th class="text-left px-6 py-4 font-semibold">
        [Icon] Column Header
      </th>
    </tr>
  </thead>
  <tbody>
    <tr class="border-b border-white/5 hover:bg-white/5">
      <td class="px-6 py-4 text-white">Data</td>
    </tr>
  </tbody>
</table>
```

#### Table Row Hover
```css
Background: rgba(255, 255, 255, 0.05)
Transition: all 0.15s
Cursor: pointer (for clickable rows)
```

#### Table Header Row
```css
Background: #1F2937
Border-bottom: 1px solid rgba(255, 255, 255, 0.1)
Text-color: #9CA3AF
Font-weight: 600
Font-size: 12px
```

---

### Search & Filter

#### Search Input
```css
Background: rgba(255, 255, 255, 0.05)
Border: 1px solid rgba(255, 255, 255, 0.1)
Color: white
Placeholder-color: #6B7280
Padding: 12px 16px
Border-radius: 12px
Font-size: 14px

Focus:
  Border-color: #8B0000
  Box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.2)
```

#### Dropdown Filter
```css
Background: rgba(255, 255, 255, 0.05)
Border: 1px solid rgba(255, 255, 255, 0.1)
Color: white
Padding: 12px 16px
Border-radius: 12px
Font-size: 14px

Options:
  Background: #1F2937
  Color: white
  Hover: #374151
```

---

### Forms & Input

#### Text Input
```css
Background: rgba(255, 255, 255, 0.05)
Border: 1px solid rgba(255, 255, 255, 0.1)
Color: white
Padding: 12px 16px
Border-radius: 12px
Font-size: 14px
Placeholder: #6B7280

Focus:
  Border: 2px solid #8B0000
  Box-shadow: 0 0 0 2px rgba(139, 0, 0, 0.1)
```

---

### Navigation

#### Sidebar Nav Item (Inactive)
```css
Display: flex
Align-items: center
Gap: 12px
Padding: 12px 16px
Color: #9CA3AF
Background: transparent
Border-radius: 12px
Transition: all 0.15s
Font-size: 14px

Hover:
  Background: rgba(255, 255, 255, 0.1)
  Color: white
```

#### Sidebar Nav Item (Active)
```css
Display: flex
Align-items: center
Gap: 12px
Padding: 12px 16px
Color: white
Background: rgba(139, 0, 0, 0.4)
Border-left: 4px solid #8B0000
Border-radius: 12px
Font-weight: 500
Font-size: 14px
```

---

### Empty States

#### Empty State Container
```css
Text-align: center
Padding: 48px 24px
Color: #6B7280

Icon (Emoji):
  Font-size: 48px
  Margin-bottom: 16px
  Opacity: 60%

Text:
  Font-size: 14px
  Color: #9CA3AF
  Margin-top: 16px

CTA Button:
  Margin-top: 24px
  Standard button styling
```

---

### User Avatar

#### Circle Avatar
```css
Width: 36px / 40px / 48px / 96px (depending on context)
Height: same as width
Background: #8B0000
Border-radius: 50%
Display: flex
Align-items: center
Justify-content: center
Color: white
Font-weight: 700
Font-size: 14px / 16px / 24px (depending on size)

First Letter: UPPERCASE
```

---

## 📐 Spacing Reference

```css
Padding:
  xs: 4px (8px)
  sm: 8px (12px)
  md: 16px (p-4)
  lg: 24px (p-6)
  xl: 32px (p-8)

Margin:
  Between sections: 32px (mb-8)
  Between rows: 12px (mb-3)
  Between cards: 16px (gap-4)

Border-radius:
  Small: 8px (rounded-lg)
  Medium: 12px (rounded-xl)
  Large: 16px (rounded-2xl)
  Full: 50% (rounded-full)
```

---

## 🎯 Key Design Principles

1. **Consistency**: Same components look/feel same everywhere
2. **Hierarchy**: Important info larger and bolder
3. **Color Coding**: Status indicated by color
4. **Icons**: Context provided by relevant emoji icons
5. **Whitespace**: Generous spacing for breathing room
6. **Responsiveness**: Works on mobile, tablet, desktop
7. **Accessibility**: Good contrast, clear labels, keyboard navigable
8. **Performance**: Minimal animations, no heavy scripts

---

## 🚀 Implementation Notes

All styling uses **Tailwind CSS** utility classes:
- `bg-[color]-[opacity]` for backgrounds
- `text-[color]-[opacity]` for text
- `border-[color]-[opacity]` for borders
- `rounded-[size]` for border-radius
- `hover:` prefix for hover states
- `transition-` for animations

Example:
```html
<button class="px-6 py-3 bg-maroon-600 hover:bg-maroon-700 text-white rounded-xl transition-colors">
  Click Me
</button>
```

---

## 📱 Responsive Breakpoints

```css
Mobile: < 640px (Single column)
Tablet: 640px - 1024px (2 columns)
Desktop: > 1024px (Full layout)
```

Grid examples:
```css
grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4
  - Mobile: 1 column
  - Tablet (md): 2 columns
  - Desktop (lg): 4 columns
```

---

**This guide provides the complete visual specification for the DigiLib Admin Panel!**
