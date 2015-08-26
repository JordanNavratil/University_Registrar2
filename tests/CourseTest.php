<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Course.php";
    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Course::deleteAll();
            Student::deleteAll();
        }

        function testGetName()
        {
            $name = "Math";
            $test_course = new Course($name);
            $result = $test_course->getName();
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            $name = "Math";
            $test_course = new Course($name);
            $test_course->setName("Science");
            $result = $test_course->getName();
            $this->assertEquals("Science", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Math";
            $id = 1;
            $test_course = new Course($name, $id);
            //Act
            $result = $test_course->getId();
            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            $name = "Math";
            $id = 1;
            $test_course = new Course($name, $id);
            $test_course->save();
            $result = Course::getAll();
            $this->assertEquals($test_course, $result[0]);
        }
        function testGetAll()
        {
            //Arrange
            $name = "Math";
            $id = 1;
            $name2 = "Science";
            $id2 = 2;
            $test_course = new Course($name, $id);
            $test_course->save();
            $test_course2 = new Course($name2, $id2);
            $test_course2->save();
            //Act
            $result = Course::getAll();
            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function testDeleteAll()
        {
            $name = "Math";
            $id = 1;
            $test_course = new Course($name);
            $test_course->save();
            $name2= "Science";
            $id2 = 2;
            $test_course2 = new Course($name2);
            $test_course2->save();
            Course::deleteAll();
            $result = Course::getAll();
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Math";
            $id = 1;
            $test_course = new Course($name, $id);
            $test_course->save();
            $new_name = "Science";
            //Act
            $test_course->update($new_name);
            //Assert
            $this->assertEquals("Science", $test_course->getName());
        }

        function testDeleteCourse()
        {
            $name = "Math";
            $id = 1;
            $test_course = new Course($name);
            $test_course->save();
            $name2= "Science";
            $id2 = 2;
            $test_course2 = new Course($name2);
            $test_course2->save();
            $test_course->delete();
            $this->assertEquals([$test_course2], Course::getAll());
        }

        function testFind()
        {
            //Arrange
            $name = "Math";
            $id = 1;
            $test_course = new Course($name, $id);
            $test_course->save();
            $name2 = "Science";
            $id2 = 2;
            $test_course2 = new Course($name2, $id2);
            $test_course2->save();
            //Act
            $result = Course::find($test_course->getId());
            //Assert
            $this->assertEquals($test_course, $result);
        }

        function testDelete()
        {
            //Arrange
            $name = "Math";
            $date = '0000-00-00';
            $id = 1;
            $test_course = new Course($name, $id);
            $test_course->save();

            $student_name = "File reports";
            $id2 = 2;
            $course_id = $test_course->getId();
            $test_student = new Student($student_name, $id2, $date, $course_id);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->delete();

            //Assert
            $this->assertEquals([], $test_student->getCourses());
        }
    }
?>
