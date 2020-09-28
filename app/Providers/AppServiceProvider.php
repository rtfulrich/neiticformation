<?php

namespace App\Providers;

use App\Student;
use App\Teacher;
use App\Formation;
use App\Http\Controllers\FeeController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\StudentController;
use Illuminate\Contracts\Events\Dispatcher;
use App\Http\Controllers\FormationSessionController;
use App\Http\Controllers\TeacherController;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('FORMATIONS|ETUDIANTS|PROFS');
            $event->menu->add(
                [
                    'text' => ' Gestion des Formations',
                    'icon' => 'fas fa-book-open',
                    'icon_color' => 'green',
                    'submenu' => [
                        [
                            'text' => ' Les formations disponibles',
                            'url' => 'formation',
                            'icon_color' => 'yellow',
                            'label' => Formation::count(),
                            'label_color' => 'danger'
                        ],
                        [
                            'text' => ' Créer une nouvelle vague',
                            'url' => 'formation/session/create',
                            'icon_color' => 'yellow',
                        ],
                        [
                            'text' => ' Les vagues en cours',
                            'url' => 'formation/sessions',
                            'icon_color' => 'yellow',
                            'label' => FormationSessionController::countActualSessions(),
                            'label_color' => 'danger'
                        ],
                        [
                            'text' => ' Les vagues expirées',
                            'url' => 'formation/sessions/expired',
                            'icon_color' => 'yellow',
                            'label' => FormationSessionController::countExpiredSessions(),
                            'label_color' => 'danger'
                        ],
                    ],
                ],
        
                [
                    'text'        => ' Gestion des Etudiants',
                    'icon'        => 'fas fa-graduation-cap',
                    'icon_color' => 'green',
                    'submenu' => [
                        [
                            'text' => ' Etudiants Actuels',
                            'url' => 'student',
                            'icon_color' => 'yellow',
                            'label' => StudentController::currentStudentsCount(),
                            'label_color' => 'danger'
                        ],
                        [
                            'text' => ' Anciens Etudiants',
                            'url' => 'student/old',
                            'icon_color' => 'yellow',
                            'label' => StudentController::oldStudentsCount(),
                            'label_color' => 'danger',
                        ],
                        [
                            'text' => ' Etudiants Certifiés',
                            'url' => 'student/certified',
                            'icon_color' => 'yellow',
                            'label' => StudentController::certifiedStudentsCount(). ' / '.  /*StudentController::oldStudentsCount()*/Student::count(),
                            'label_color' => 'danger',
                        ],    
                    ],
                ],
        
                [
                    'text' => ' Gestion des Profs',
                    'icon' => 'fas fa-user-tie',
                    'icon_color' => 'green',
                    'submenu' => [
                        [
                            'text' => " Tous les pros",
                            'url' => "teacher",
                            'icon_color' => 'yellow',
                            'label' => TeacherController::countTeachers(),
                            'label_color' => 'danger'
                        ],
                    ],
                ]
            );

            $event->menu->add('GESTION DES ECOLAGES');
            $event->menu->add([
                'text' => 'Retard de Paiment',
                'icon' => 'fas fa-money-bill-alt',
                'icon_color' => (FeeController::studentsWithFeeProblems('count') > 0) ? 'danger' : 'success',
                'url' => 'fee-problems',
                'label' => FeeController::studentsWithFeeProblems('count'),
                'label_color' => (FeeController::studentsWithFeeProblems('count') > 0) ? 'danger' : 'success',
            ]);

            $event->menu->add('ACCOUNT SETTINGS');
            $event->menu->add([
                'text' => 'Modifier le mot de passe',
                'icon' => 'fas fa-address-card',
                'icon_color' => 'green',
                'url' => 'password/reset',
            ]);
        });
    }
}
