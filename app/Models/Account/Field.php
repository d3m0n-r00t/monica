<?php

namespace App\Models\Account;

use Parsedown;
use App\Helpers\DateHelper;
use App\Traits\Journalable;
use App\Models\Contact\Contact;
use App\Models\Journal\JournalEntry;
use Illuminate\Database\Eloquent\Model;
use App\Models\Instance\Emotion\Emotion;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Resources\Contact\ContactShort as ContactShortResource;

class Field extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fields';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the custom field ecord associated with the field.
     *
     * @return BelongsTo
     */
    public function customField()
    {
        return $this->belongsTo(CustomField::class, 'custom_field_id');
    }


    /**
     * Get the value of the field for the given contact.
     *
     * @param Contact $contact
     * @throws ModelNotFoundException
     * @return string
     */
    public function getValueForContact(Contact $contact): string
    {
        $contactFieldValue = ContactFieldValue::where('contact_id', $contact->id)
            ->where('field_id', $this->id)
            ->firstOrFail();

        return $contactFieldValue->value;
    }
}
