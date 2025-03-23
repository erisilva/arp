<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'model',
        'model_id',
        'action',
        'changes',
    ];

    /**
     * Get the user that owns the log.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * filter
     */

    public function scopeFilter($query, array $filters)
    {
         // start session values if not yet initialized
         if (!session()->exists('log_view_data_inicio')){
            session(['log_view_data_inicio' => '']);
        }

        if (!session()->exists('log_view_data_fim')){
            session(['log_view_data_fim' => '']);
        }

        if (!session()->exists('log_view_user')){
            session(['log_view_user' => '']);
        }

        if (!session()->exists('log_view_model')){
            session(['log_view_model' => '']);
        }

        if (!session()->exists('log_view_action')){
            session(['log_view_action' => '']);
        }

        if (!session()->exists('log_view_id')){
            session(['log_view_id' => '']);
        }

        // update session values if the request has a value

        if (Arr::exists($filters, 'data_inicio')) {
            session(['log_view_data_inicio' => $filters['data_inicio'] ?? '']);
        }

        if (Arr::exists($filters, 'data_fim')) {
            session(['log_view_data_fim' => $filters['data_fim'] ?? '']);
        }

        if (Arr::exists($filters, 'user')) {
            session(['log_view_user' => $filters['user'] ?? '']);
        }

        if (Arr::exists($filters, 'model')) {
            session(['log_view_model' => $filters['model'] ?? '']);
        }

        if (Arr::exists($filters, 'action')) {
            session(['log_view_action' => $filters['action'] ?? '']);
        }

        if (Arr::exists($filters, 'id')) {
            session(['log_view_id' => $filters['id'] ?? '']);
        }

        // query if session filters are not empty

        if (trim(session()->get('log_view_data_inicio')) !== '') {
            $query->where('data_inicio', '>=', session()->get('log_view_data_inicio'));
        }

        if (trim(session()->get('log_view_data_fim')) !== '') {
            $query->where('data_fim', '<=', session()->get('log_view_data_fim'));
        }

        if (trim(session()->get('log_view_user')) !== '') {
            $query->whereHas('user', function ($query) {
                $query->where('name', 'like', '%' . session()->get('log_view_user') . '%');
            });
        }

        if (trim(session()->get('log_view_model')) !== '') {
            $query->where('model', 'like', '%' . session()->get('log_view_model') . '%');
        }

        if (trim(session()->get('log_view_action')) !== '') {
            $query->where('action', 'like', '%' . session()->get('log_view_action') . '%');
        }

        if (trim(session()->get('log_view_id')) !== '') {
            $query->where('model_id', session()->get('log_view_id'));
        }

    }
}
