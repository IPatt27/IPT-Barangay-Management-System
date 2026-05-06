<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property string $case_number
 * @property string $incident_type
 * @property \Illuminate\Support\Carbon $incident_date
 * @property string $incident_location
 * @property string $incident_description
 * @property string $status
 * @property string $recorded_by
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlotterAttachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BlotterParty> $parties
 * @property-read int|null $parties_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereCaseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereIncidentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereIncidentDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereIncidentLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereIncidentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Blotter whereUpdatedAt($value)
 */
	class Blotter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $blotter_id
 * @property string $file_name
 * @property string $file_path
 * @property string|null $file_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Blotter $blotter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereBlotterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterAttachment whereUpdatedAt($value)
 */
	class BlotterAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $blotter_id
 * @property int|null $resident_id
 * @property string $name
 * @property string|null $address
 * @property string|null $contact
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Blotter $blotter
 * @property-read \App\Models\Resident|null $resident
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereBlotterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereResidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BlotterParty whereUpdatedAt($value)
 */
	class BlotterParty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $business_name
 * @property string $owner_name
 * @property string $business_type
 * @property string $address
 * @property string $contact_number
 * @property string $permit_number
 * @property string $reference_number
 * @property string $issued_date
 * @property string $expiry_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereBusinessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereIssuedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business wherePermitNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Business whereUpdatedAt($value)
 */
	class Business extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $committee_name
 * @property string $chairperson
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereChairperson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereCommitteeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Committee whereUpdatedAt($value)
 */
	class Committee extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $resident_id
 * @property string $document_type
 * @property string $purpose
 * @property string|null $or_number
 * @property string|null $issued_by
 * @property string|null $position
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Resident $resident
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereIssuedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereOrNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereResidentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $household_code
 * @property int $purok_id
 * @property string $head_of_family
 * @property int $family_size
 * @property int $voter_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Purok $purok
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Resident> $residents
 * @property-read int|null $residents_count
 * @method static \Database\Factories\HouseholdFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereFamilySize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereHeadOfFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereHouseholdCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household wherePurokId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Household whereVoterCount($value)
 */
	class Household extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $position
 * @property string|null $designation
 * @property string|null $contact
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $birthdate
 * @property \Illuminate\Support\Carbon|null $term_start
 * @property \Illuminate\Support\Carbon|null $term_end
 * @property string|null $photo
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereTermEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereTermStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereUpdatedAt($value)
 */
	class Official extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $leader_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Household> $households
 * @property-read int|null $households_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Resident> $residents
 * @property-read int|null $residents_count
 * @method static \Database\Factories\PurokFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok whereLeaderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Purok whereUpdatedAt($value)
 */
	class Purok extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $age
 * @property string $sex
 * @property int $is_voter
 * @property string $birthdate
 * @property string $civil_status
 * @property string $address
 * @property string $contact_number
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $purok_id
 * @property int|null $household_id
 * @property-read \App\Models\Household|null $household
 * @property-read \App\Models\Purok|null $purok
 * @method static \Database\Factories\ResidentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereCivilStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereHouseholdId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereIsVoter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident wherePurokId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Resident whereUpdatedAt($value)
 */
	class Resident extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent {}
}

