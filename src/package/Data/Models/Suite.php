<?php

namespace PragmaRX\Tddd\Package\Data\Models;

class Suite extends Model
{
    protected $table = 'tddd_suites';

    protected $fillable = [
        'name',
        'project_id',
        'tester_id',
        'tests_path',
        'suite_path',
        'file_mask',
        'command_options',
        'max_retries',
        'editor',
        'coverage_enabled',
        'coverage_index',
    ];

    /**
     * Get the full path.
     *
     * @param $value
     *
     * @return mixed|string
     */
    public function getTestsFullPathAttribute($value)
    {
        return make_path(
            [
                $this->project->tests_full_path,
                $this->tests_path,
            ]
        );
    }

    /**
     * Project relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('PragmaRX\Tddd\Package\Data\Models\Project');
    }

    /**
     * Tester relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tester()
    {
        return $this->belongsTo('PragmaRX\Tddd\Package\Data\Models\Tester');
    }

    /**
     * Tests relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany('PragmaRX\Tddd\Package\Data\Models\Test');
    }

    /**
     * Get the test command.
     *
     * @return mixed
     */
    public function getTestCommandAttribute()
    {
        $command = $this->tester->command.' '.$this->command_options;

        return str_replace('%project_path%', $this->project->path, $command);
    }
}
