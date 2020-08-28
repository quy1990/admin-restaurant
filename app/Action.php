<?php

namespace App;

class Action
{
    const RETRIEVED = 1; // after a record has been retrieved.
    const CREATING = 2; // before a record has been created.
    const CREATED = 3; //after a record has been created.
    const UPDATING = 4; // before a record is updated.
    const UPDATED = 5;  // after a record has been updated.
    const SAVING = 6; // before a record is saved (either created or updated).
    const SAVED = 7; // after a record has been saved (either created or updated).
    const DELETING = 8; // before a record is deleted or soft-deleted.
    const DELETED = 9; // after a record has been deleted or soft-deleted.
    const RESTORING = 10; // before a soft-deleted record is going to be restored.
    const RESTORED = 11; // after a soft-deleted record has been restored.
}
