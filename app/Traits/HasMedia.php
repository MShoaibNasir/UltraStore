<?php

namespace App\Traits;

use App\Media;

trait HasMedia
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasMedia()
    {
        static::saved(function ($entity) {
            $entity->updateFiles(request('files', []));
        });
    }

    /**
     * Get all of the files for the entity.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function files()
    {
        return $this->morphToMany(Media::class, 'entity', 'entity_files')
					->withPivot(['id', 'name'])
					->withTimestamps();
    }

    /**
     * Filter files by name.
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterFiles($name)
    {
        return $this->files()->wherePivot('name', $name);
    }

    /**
     * Store/Update files for the entity.
     *
     * @param array $files
     */
    public function updateFiles($files = [])
    {
        //$this->files()->detach();

        $entityType = get_class($this);

        foreach ($files as $name => $fileIds) {
            $syncList = [];

            if(! is_array($fileIds)){
                if (! empty($fileIds)) {
                    $syncList[$fileIds]['name'] = $name;
                    $syncList[$fileIds]['entity_type'] = $entityType;
                }
            }else{
                foreach($fileIds as $fieldId){
                    if (! empty($fieldId)) {
                        $syncList[$fieldId]['name'] = $name;
                        $syncList[$fieldId]['entity_type'] = $entityType;
                    }
                }
            }

            $this->filterFiles($name)->detach();
            $this->filterFiles($name)->attach($syncList);
        }
    }
}
