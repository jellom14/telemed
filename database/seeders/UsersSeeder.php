<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        // ADMIN
        $user = new User;
        $user->userTypeId = 1;
        $user->email = 'jello@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Jello';
        $user->lastName = 'Monasterial';
        $user->address = 'PH';
        $user->dob = '01-01-2023';
        $user->bloodPressure = '90';
        $user->bloodType = 'A+';
        $user->gender = 'male';
        $user->phone = '1234567890';
        $user->save();

        // DOCTOR
        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 3;
        $user->email = 'jona@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Jona';
        $user->lastName = 'Quirimit';
        $user->address = 'PH';
        $user->dob = '01-01-2023';

        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = '1000';

        $user->qualificationId = 3;
        $user->specialityId = 3;
        $user->medicalSchoolOfGraduation = 'Mapua University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '28/6/2029';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 1;
        $user->email = 'drenciso@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Rose';
        $user->lastName = 'Enciso';
        $user->address = 'PH';
        $user->dob = '01-27-1965';

        $user->gender = 'Female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = '1000';

        $user->qualificationId = 1;
        $user->specialityId = 1;
        $user->medicalSchoolOfGraduation = 'Adamson University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '7/11/2020';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 1;
        $user->email = 'drmorales@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Victoria';
        $user->lastName = 'Morales';
        $user->address = 'PH';
        $user->dob = '06-27-1970';

        $user->gender = 'Female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = "1000";

        $user->qualificationId = 4;
        $user->specialityId = 4;
        $user->medicalSchoolOfGraduation = 'Jose Rizal University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '17/2/2015';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 2;
        $user->email = 'drafable@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Malou';
        $user->lastName = 'Afable';
        $user->address = 'PH';
        $user->dob = '06-23-1963';

        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = "1000";

        $user->qualificationId = 2;
        $user->specialityId = 2;
        $user->medicalSchoolOfGraduation = 'La Salle University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '24/6/2023';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 3;
        $user->email = 'drrenato@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Renato';
        $user->lastName = 'Gomez';
        $user->address = 'PH';
        $user->dob = '11-17-1967';

        $user->gender = 'Male';
        $user->phone = '1234567890';
        $user->videoConsultationFee = '1000';

        $user->qualificationId = 3;
        $user->specialityId = 3;
        $user->medicalSchoolOfGraduation = 'TIP University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '7/11/1967';

        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 4;
        $user->email = 'drtere@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Tere';
        $user->lastName = 'Sita';
        $user->address = 'PH';
        $user->dob = '01-25-1978';

        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = '1000';

        $user->qualificationId = 4;
        $user->specialityId = 4;
        $user->medicalSchoolOfGraduation = 'CE University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '29/1/2018';
        $user->save();

        $user = new User;
        $user->userTypeId = 2;
        $user->cadersId = 5;
        $user->email = 'draragon@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Vicky';
        $user->lastName = 'Aragon';
        $user->address = 'PH';
        $user->dob = '05-25-1969';

        $user->gender = 'female';
        $user->phone = '1234567890';
        $user->videoConsultationFee = '1000';

        $user->qualificationId = 5;
        $user->specialityId = 5;
        $user->medicalSchoolOfGraduation = 'AMA University';
        $user->boardCertified = true;
        $user->pdeaRegistrationNumber = '1234567890';
        $user->currentMedicalLicenseNumber = '095612345';
        $user->currentMedicalLicenseNumberDateIssued = '28/6/2029';
        $user->save();

        // PATIENT
        $user = new User;
        $user->userTypeId = 3;
        $user->email = 'roby@gmail.com';
        $user->password = Hash::make('1234');
        $user->firstName = 'Roby';
        $user->lastName = 'Sulit';
        $user->address = 'PH';
        $user->dob = '01-01-2023';
        $user->bloodPressure = '90';
        $user->bloodType = 'B+';
        $user->gender = 'male';
        $user->phone = '1234567890';
        $user->save();

    }

}