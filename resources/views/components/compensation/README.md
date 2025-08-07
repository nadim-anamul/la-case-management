# Ownership Continuity Section - Story Sequence Feature

## Overview
The ownership continuity section now includes a story sequence feature that allows users to create a chronological narrative of ownership transfers and records. This feature maintains the order in which items were added and displays them in a story-like format.

## Features

### Story Sequence Display
- **Visual Timeline**: Items are displayed in the order they were added with numbered indicators
- **Descriptive Cards**: Each item shows its type and relevant details
- **Interactive Navigation**: Click on any item to scroll to its corresponding form
- **Real-time Updates**: Descriptions update automatically as form fields are filled

### Supported Item Types
1. **দলিলমূলে মালিকানা হস্তান্তর** (Deed Transfer)
   - Shows deed number in description
   - Updates when deed number is entered

2. **ওয়ারিশমূলে হস্তান্তর** (Inheritance Transfer)
   - Shows previous owner name in description
   - Updates when previous owner name is entered

3. **আরএস রেকর্ড যোগ** (RS Record)
   - Shows plot number in description
   - Updates when plot number is entered

## Technical Implementation

### Data Structure
```javascript
storySequence: [
    {
        type: "দলিলমূলে মালিকানা হস্তান্তর",
        description: "দলিল নম্বর: 12345",
        itemType: "deed",
        itemIndex: 0,
        sequenceIndex: 0
    }
]
```

### Key Methods
- `addDeedTransfer()`: Adds deed transfer to story sequence
- `addInheritanceRecord()`: Adds inheritance record to story sequence
- `addRsRecord()`: Adds RS record to story sequence
- `removeStoryItem(index)`: Removes item from story sequence
- `updateStoryItemDescriptions()`: Updates all descriptions based on form data
- `scrollToStoryItem(item)`: Scrolls to corresponding form

### Form Integration
- Story sequence data is saved with the ownership details
- Preview page displays story sequence in chronological order
- Backward compatibility with existing data structure

## Usage

1. **Adding Items**: Click the respective buttons to add items to the story sequence
2. **Editing**: Fill in the form fields to update the descriptions automatically
3. **Navigation**: Click on any story item to jump to its form
4. **Removal**: Click the delete button on any story item to remove it
5. **Saving**: Story sequence is automatically saved with the form data

## Preview Display
The preview page shows the story sequence in a clean, numbered format with:
- Sequential numbering
- Item type and description
- Consistent styling with the rest of the form

## Migration Notes
- Existing data without story sequence will be converted automatically
- Old `transferItems` array is converted to `storySequence` format
- No data loss during migration 