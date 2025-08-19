<?php

namespace App\Controllers;

use App\Models\EventModel;

class Event extends BaseController
{
    public function index()
    {
        log_message('debug', 'Session user_id: ' . session('user_id'));
        $userId = session('user_id');
        $eventModel = new EventModel();
        $events = $eventModel->where('user_id', $userId)->findAll();

        // Format data untuk FullCalendar
        $formatted = [];
        foreach ($events as $ev) {
            $formatted[] = [
                'id' => $ev['id'],
                'title' => $ev['title'],
                'start' => $ev['start'],
                'end' => $ev['end'],
                'description' => $ev['description'],
                'backgroundColor' => $ev['color'] ?? '#3788d8',
                'start_time' => $ev['start_time'],
                'end_time' => $ev['end_time'],
            ];
        }

        return $this->response->setJSON($formatted);
    }

    public function create()
    {
        $json = $this->request->getJSON(true);
        log_message('debug', 'Event JSON: ' . json_encode($json));
        log_message('debug', 'Session user_id: ' . session('user_id'));

        $eventModel = new EventModel();

        $data = [
            'title' => $json['title'] ?? '',
            'start' => $json['start'] ?? '',
            'end' => $json['end'] ?? '',
            'description' => $json['description'] ?? '',
            'user_id' => session('user_id'),
            'color' => $json['color'] ?? '#3788d8',
            'start_time' => $json['start_time'] ?? '',
            'end_time' => $json['end_time'] ?? '',
        ];

        if (!$data['title'] || !$data['start'] || !$data['user_id']) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }

        $eventModel->insert($data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function update($id)
    {
        $json = $this->request->getJSON(true);
        log_message('debug', 'Update Event JSON: ' . json_encode($json));
        log_message('debug', 'Session user_id: ' . session('user_id'));

        $eventModel = new EventModel();

        $data = [
            'title' => $json['title'] ?? '',
            'start' => $json['start'] ?? '',
            'end' => $json['end'] ?? '',
            'description' => $json['description'] ?? '',
            'color' => $json['color'] ?? '#3788d8',
            'start_time' => $json['start_time'] ?? '',
            'end_time' => $json['end_time'] ?? '',
        ];

        // Validasi minimal
        if (!$data['title'] || !$data['start']) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap']);
        }

        $eventModel->update($id, $data);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $eventModel = new EventModel();
        $eventModel->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }
}
