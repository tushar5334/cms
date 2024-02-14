<?php

namespace App\Exports\Admin;

use App\Models\Admin\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserReportExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    use Exportable;

    public function collection()
    {
        $db_prefix = getenv('DB_PREFIX');
        $userData = User::select(
            'name',
            'email',
            DB::RAW('DATE_FORMAT(created_at, "%d-%m-%Y") as createdAt'),
            //'status'
            DB::RAW('IF(' . $db_prefix . 'users.status="1", "Active", "Inactive") as status')
            //DB::RAW('IF(users.status="1", "Active", "Inactive") as status')
        );
        if (!empty($this->requestData['startDate']) && !empty($this->requestData['endDate'])) {
            $endDate = Carbon::createFromFormat('d/m/Y', $this->requestData['endDate'])->format('Y-m-d');
            $startDate = Carbon::createFromFormat('d/m/Y', $this->requestData['startDate'])->format('Y-m-d');
            $userData->whereBetween(DB::RAW('DATE_FORMAT(created_at, "%Y-%m-%d")'), [$startDate, $endDate]);
        }
        if (!empty($this->requestData['startDate']) && empty($this->requestData['endDate'])) {
            $startDate = Carbon::createFromFormat('d/m/Y', $this->requestData['startDate'])->format('Y-m-d');
            $userData->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($this->requestData['endDate']) && empty($this->requestData['startDate'])) {
            $endDate = Carbon::createFromFormat('d/m/Y', $this->requestData['endDate'])->format('Y-m-d');
            $userData->whereDate('created_at', '<=', $endDate);
        }
        if (!empty($this->requestData['searchData'])) {
            $keyword = $this->requestData['searchData'];
            $userData->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->orWhere('email', 'like', '%' . $keyword . '%');
                $query->orWhere(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), 'like', '%' . $keyword . '%');
            });
        }
        $userData->where('user_type', "User");
        $userData = $userData->get();
        return $userData;
    }
    public function headings(): array
    {
        return ['Name', 'Email', 'Created At', 'Status'];
    }
}
