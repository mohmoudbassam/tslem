<?php

namespace App\Models;

use App\Traits\THasPathAttribute;
use App\Traits\TModelTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class FinalReport extends Model
{
    use HasFactory;
    use TModelTranslation;
    use THasPathAttribute;

    /**
     * @var string
     */
    public static $DISK = 'order_final_reports';

    protected $fillable = [
        'order_id',
        'contractor_final_report_path',
        'contractor_final_report_note',
        'contractor_final_report_approved',
        'consulting_office_final_report_path',
        'consulting_office_final_report_note',
        'consulting_office_final_report_approved',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'contractor_final_report_path' => 'string',
        'contractor_final_report_note' => 'string',
        'contractor_final_report_approved' => 'boolean',
        'consulting_office_final_report_path' => 'string',
        'consulting_office_final_report_note' => 'string',
        'consulting_office_final_report_approved' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // region: contractor_final_report_path
    public function getContractorFinalReportPathUrlAttribute()
    {
        return $this->getPathUrlAttribute('contractor_final_report_path');
    }

    public function setContractorFinalReportPathAttribute($value)
    {
        $this->setPathAttribute('contractor_final_report_path', $value);
    }
    // endregion: contractor_final_report_path

    // region: consulting_office_final_report_path
    public function getConsultingOfficeFinalReportPathUrlAttribute()
    {
        return $this->getPathUrlAttribute('consulting_office_final_report_path');
    }

    public function setConsultingOfficeFinalReportPathAttribute($value)
    {
        $this->setPathAttribute('consulting_office_final_report_path', $value);
    }

    // endregion: consulting_office_final_report_path

    public function contractor_approve(bool $approve = true, bool $save = false)
    {
        $this->contractor_final_report_approved = $approve;
        $this->contractor_final_report_note = "";

        if( $save ) {
            $this->save();
        }

        return $this;
    }

    public function consulting_office_approve(bool $approve = true, bool $save = false)
    {
        $this->consulting_office_final_report_approved = $approve;
        $this->consulting_office_final_report_note = "";

        if( $save ) {
            $this->save();
        }

        return $this;
    }

    public function contractor_reject($note = "", bool $save = false)
    {
        $this->contractor_final_report_approved = false;
        $this->contractor_final_report_note = $note;

        if( $save ) {
            $this->save();
        }

        return $this;
    }

    public function consulting_office_reject($note = "", bool $save = false)
    {
        $this->consulting_office_final_report_approved = false;
        $this->consulting_office_final_report_note = $note;

        if( $save ) {
            $this->save();
        }

        return $this;
    }

    public function isFullyApproved(): bool
    {
        return $this->contractor_final_report_approved && $this->consulting_office_final_report_approved;
    }

    public function hasContractorReport(): bool
    {
        return (bool)$this->contractor_final_report_path;
    }

    public function hasConsultingOfficeReport(): bool
    {
        return (bool)$this->consulting_office_final_report_path;
    }
}
