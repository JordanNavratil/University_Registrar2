<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function testSetStudentName()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student= new Student($student_name, $id, $date, $course_id);

            //Act
            $test_student->setStudentName("Student1");
            $result = $test_student->getStudentName();

            //Assert
            $this->assertEquals("Student1", $result);
        }

        function testGetStudentName()
        {
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student = new Student ($student_name, $id, $date, $course_id);

            $result = $test_student->getStudentName();
            $this->assertEquals($student_name, $result);
        }

        function testGetId()
        {
            $name = "Math";
            $date = '0000-00-00';
            $id = 1;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student = new Student ($student_name, $id, $date, $course_id);

            $result = $test_student->getId();

            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student = new Student ($student_name, $id, $date, $course_id);

            $test_student->save();

            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $id = 1;
            $course_id = $test_course->getId();

            $student_name2 = "Student2";
            $id2 = 2;
            $course_id2 = $test_course->getId();


            $test_student = new Student($student_name, $id, $date, $course_id);
            $test_student->save();

            $test_student2 = new Student($student_name2, $id2, $date, $course_id2);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $id = 1;
            $course_id = $test_course->getId();

            $student_name2 = "Student2";
            $id2 = 2;
            $course_id2 = $test_course->getId();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $id = 1;
            $course_id = $test_course->getId();
            $test_student = new Student($student_name, $id, $date, $course_id);
            $test_student->save();

            $student_name2 = "Student2";
            $id2 = 2;
            $course_id2 = $test_course->getId();
            $test_student2 = new Student($student_name2, $id2, $date, $course_id2);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);


        }

        function testUpdate()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student = new Student($student_name, $id, $date, $course_id);
            $test_student->save();

            $new_student_name = "Student2";

            //Act
            $test_student->update($new_student_name);

            //Assert
            $this->assertEquals("Student2", $test_student->getStudentName());
        }

        function testDelete()
        {
            $name = "Math";
            $date = '0000-00-00';
            $id = null;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "Student1";
            $course_id = $test_course->getId();
            $test_student = new Student($student_name, $id, $date, $course_id);
            $test_student->save();

            $test_student->addCourse($test_course);
            $test_student->delete();

            $this->assertEquals([], $test_course->getStudents());
        }

    }
?>
