<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Anime
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $country
 * @property string $genre
 * @property string $type
 * @property int $current_episodes
 * @property int $count_episodes
 * @property string $release_date
 * @property int $views
 * @property int $poster_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Anime newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime query()
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereCurentEpisodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereDescrption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereEpisodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime wherePosterUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Anime whereViews($value)
 * @mixin \Eloquent
 */
class Anime extends Model
{
    public const NO_SEASON = 0;
    public const SPRING_SEASON = 1;
    public const SUMMER_SEASON = 2;
    public const FALL_SEASON = 3;
    public const WINTER_SEASON = 4;

    protected $fillable = [
        "name",
        "name_origin",
        "studio",
        "description",
        "country",
        "type",
        "season",
        "current_episodes",
        "count_episodes",
        "release_date",
        "views",
        "poster_id",
    ];

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function episodes()
    {
        return $this->morphedByMany('App\Models\Episode', 'animeable');
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function genres()
    {
        return $this->morphedByMany('App\Models\Genre', 'animeable');
    }

    public function figures()
    {
        return $this->morphedByMany('App\Models\Figure', 'animeable');
    }

    public function poster()
    {
        return $this->belongsTo(File::class);
    }
}
