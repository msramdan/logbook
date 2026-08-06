<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Generators\Services\ImageServiceV2;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['nama_event', 'tanggal_mulai', 'tanggal_selesai','kode_sertifikat','template_sertifikat', 'nama_ncs', 'callsign_ncs', 'poster'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['nama_event' => 'string', 'tanggal_mulai' => 'datetime:Y-m-d H:i:s', 'tanggal_selesai' => 'datetime:Y-m-d H:i:s', 'nama_ncs' => 'string', 'callsign_ncs' => 'string', 'created_at' => 'datetime:Y-m-d H:i:s', 'updated_at' => 'datetime:Y-m-d H:i:s'];
    }





    /**
     * Accessor for the 'template_sertifikat' attribute.
     */
    protected function templateSertifikat(): Attribute
    {
        $path = 'template-sertifikats';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');

        return Attribute::make(
            get: fn(?string $value): string => $imageService->getImageCastUrl(image: $value, path: $path, disk: $disk)
        );
    }

	/**
     * Accessor for the 'poster' attribute.
     */
    protected function poster(): Attribute
    {
        $path = 'posters';
        $imageService = new ImageServiceV2();
        $disk = $imageService->setDiskName(disk: 'public');

        return Attribute::make(
            get: fn(?string $value): string => $imageService->getImageCastUrl(image: $value, path: $path, disk: $disk)
        );
    }


}
