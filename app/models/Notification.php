<?php

/**
 *
 */
class Notification extends Eloquent
{

    protected $table = 'notifications';
    protected $timestamp = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'sensor_id',
        'type',
        'title',
        'message',
        'read',
        'date'
    ];

    static public function getUnreaded()
    {
        return self::unreaded()->get();
    }

    static public function getUnreadedByUser(User $user)
    {
        return self::getByUser($user)->unreaded()->get();
    }

    static public function getByUser(User $user)
    {
        return self::whereIn('sensor_id', $user->sensors->lists('post_id'));
    }

    public function setRead()
    {
        return 11;
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnreaded($query)
    {
        return $query->where('read', 0);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReaded($query)
    {
        return $query->where('read', 1);
    }

    public function getPretyDateTime()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->date)->format('H:i - d/m/Y');
    }

    public function getStatusText()
    {
        return ($this->read) ? 'Lida' : 'Não Lida';
    }

    public function sensor()
    {
        return $this->belongsTo('Post', 'sensor_id', 'post_id');
    }

}