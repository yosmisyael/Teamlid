<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Attendance;
use App\Models\Bank;
use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use App\Models\Leave;
use App\Models\Position;
use App\Models\Salary;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('TRUNCATE TABLE employees RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE positions RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE job_profiles RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE departments RESTART IDENTITY CASCADE');

        // setup admin account
        $admin = Admin::query()->create([
            'name' => 'Jose Michael',
            'email' => 'jose@gmail.com',
            'password' => bcrypt('test1234'),
        ]);

        $company = Company::query()->create([
            'name' => 'Stardrop Computing',
            'registered_by' =>  $admin->id,
            'address' => 'Silicon Valley, United States',
            'website' => 'www.stardrop.com',
            'founded_date' => Carbon::now(),
            'phone' => '+1 754678',
            'description' => 'Leading AI Research Company',
            'field' => 'Technology, AI'
        ]);

        $departmentNames = [
            'Cloud Infrastructure',
            'Financial Planning',
            'Global Marketing',
            'Core Product Development',
            'Legal & Compliance'
        ];

        // setup authorized banks
        $bankNames = ['BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB Niaga', 'Danamon', 'Jago', 'BSI'];
        $banks = collect();
        foreach ($bankNames as $name) {
            $banks->push(Bank::query()->create([
                'name' => $name,
                'status' => 'available',
                'company_id' => $company->id
            ]));
        }

        $positionLevels = ['Intern', 'Junior', 'Senior'];

        $departments = [];
        $allEmployees = collect();

        foreach ($departmentNames as $deptName) {
            $departments[] = Department::factory()->create([
                'name' => $deptName,
                'company_id' => $company->id,
            ]);
        }

        foreach ($departments as $department) {
            Job::factory(3)->create([
                'department_id' => $department->id,
            ])->each(function (Job $jobProfile) use ($banks, $department, $positionLevels, &$allEmployees) {
                foreach ($positionLevels as $level) {
                    $position = Position::factory()->available()->create([
                        'name' => $level . ' ' . $jobProfile->name,
                        'department_id' => $department->id,
                        'job_id' => $jobProfile->id,
                        'status' => 'unavailable',
                    ]);
                    $employee = Employee::factory()->create([
                        'department_id' => $department->id,
                        'job_id' => $jobProfile->id,
                        'position_id' => $position->id,
                        'status' => 'active',
                    ]);
                    $allEmployees->push($employee);

                    $baseSalary = match ($level) {
                        'Intern' => rand(3_000_000, 4_500_000),
                        'Junior' => rand(6_000_000, 10_000_000),
                        'Senior' => rand(12_000_000, 25_000_000),
                        default => 5_000_000
                    };

                    $allowance = rand(500_000, 2_000_000);

                    $totalEarnings = $baseSalary + $allowance;
                    $maxCut = (int) ($totalEarnings * 0.20);
                    $cut = rand(50_000, $maxCut);

                    Salary::query()->create([
                        'employee_id' => $employee->id,
                        'bank_id' => $banks->random()->id,
                        'bank_account' => (string) rand(1000000000, 9999999999),
                        'base_salary' => $baseSalary,
                        'allowance' => rand(500_000, 2_000_000),
                        'cut' => $cut,
                    ]);
                }
            });
        }

        $startDate = Carbon::now()->subDays(60);
        $endDate = Carbon::now();

        foreach ($allEmployees as $employee) {
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                if ($date->isWeekend()) {
                    continue;
                }

                $rand = rand(1, 100);

                if ($rand <= 90) {
                    $isLate = rand(1, 100) <= 5;

                    if ($isLate) {
                        $lateMinutes = rand(1, 100) <= 80 ? rand(1, 20) : rand(21, 60);

                        $checkIn = Carbon::parse('08:00')->addMinutes($lateMinutes)->format('H:i:s');
                        $status = 'late';
                    } else {
                        $checkIn = Carbon::parse('07:30')->addMinutes(rand(0, 29))->format('H:i:s');
                        $status = 'attended';
                    }

                    $checkOut = Carbon::parse('17:00')->addMinutes(rand(0, 60))->format('H:i:s');

                    Attendance::query()->create([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'check_in_at' => $checkIn,
                        'check_out_at' => $checkOut,
                        'status' => $status,
                    ]);

                } elseif ($rand <= 95) {
                    // 5% Sick Leave
                    Attendance::query()->create([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'check_in_at' => null,
                        'check_out_at' => null,
                        'status' => 'sick leave',
                    ]);
                } elseif ($rand <= 98) {
                    // 3% Annual Leave
                    Attendance::query()->create([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'check_in_at' => null,
                        'check_out_at' => null,
                        'status' => 'annual leave',
                    ]);
                } else {
                    // 2% absent
                    Attendance::query()->create([
                        'employee_id' => $employee->id,
                        'date' => $date->format('Y-m-d'),
                        'check_in_at' => null,
                        'check_out_at' => null,
                        'status' => 'absent',
                    ]);
                }
            }
        }

        $employeesWithLeave = $allEmployees->random((int) ($allEmployees->count() * 0.6));

        foreach ($employeesWithLeave as $employee) {
            $leaveCount = rand(1, 3);

            for ($i = 0; $i < $leaveCount; $i++) {
                $scenario = rand(1, 100);

                $leaveStatus = 'pending';
                $startDate = Carbon::now();
                $endDate = Carbon::now();
                $reason = 'Cuti Keperluan Pribadi';

                if ($scenario <= 40) {
                    $leaveStatus = 'approved';
                    $startDate = Carbon::now()->subDays(rand(10, 60));
                    $endDate = $startDate->copy()->addDays(rand(0, 2));

                    $period = CarbonPeriod::create($startDate, $endDate);
                    foreach ($period as $date) {
                        if ($date->isWeekend()) continue;

                        Attendance::updateOrCreate(
                            [
                                'employee_id' => $employee->id,
                                'date' => $date->format('Y-m-d'),
                            ],
                            [
                                'status' => 'annual leave',
                                'check_in_at' => null,
                                'check_out_at' => null,
                            ]
                        );
                    }

                } elseif ($scenario <= 70) {
                    $leaveStatus = 'rejected';
                    $startDate = Carbon::now()->subDays(rand(10, 60));
                    $endDate = $startDate->copy()->addDays(rand(0, 2));
                    $reason = 'Cuti Liburan Mendadak';

                } else {
                    $leaveStatus = 'pending';
                    $startDate = Carbon::now()->addDays(rand(3, 10));
                    $endDate = $startDate->copy()->addDays(rand(0, 2));
                    $reason = 'Rencana Cuti Tahunan';
                }

                Leave::create([
                    'employee_id' => $employee->id,
                    'reason' => $reason,
                    'status' => $leaveStatus,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }
        }

        foreach ($departments as $department) {
            $manager = $allEmployees
                ->where('department_id', $department->id)
                ->random();

            $department->update(['manager_id' => $manager->id]);
        }

        echo "Database seeded successfully:\n";
        echo " - " . count($departments) . " Departments created.\n";
        echo " - " . Bank::query()->count() . " Bank records created.\n";
        echo " - " . Job::query()->count() . " Job Profiles created (5 departments * 3 jobs = 15).\n";
        echo " - " . Position::query()->count() . " Positions created (15 jobs * 3 levels = 45).\n";
        echo " - " . Salary::query()->count() . " Salary records created.\n";
        echo " - " . Employee::query()->count() . " Employees created (45 positions * 1 employee = 45).\n";
    }
}
