<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
        }

        function testSetName()
        {
            //Arrange
            $name = "Student1";
            $test_student= new Student($name);

            //Act
            $test_student->setName("Student1");
            $result = $test_student->getName();

            //Assert
            $this->assertEquals("Student1", $result);
        }

        function testGetName()
        {
            //Arrange
            $name = "Student1";
            $test_student = new Student($name);

            //Act
            $result = $test_student->getName();

            //Assert
            $this->assertEquals($name, $result);

        }

        function testGetId()
        {
            //Arrange
            $name = "Student1";
            $id = 1;
            $test_student = new Student($name, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Student1";
            $id = 1;
            $test_student = new Student($name, $id);

            //Act
            $test_student->save();
            // var_dump($test_student);

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }



        function testGetAll()
        {
            //Arrange
            $name = "Student1";
            $id = 1;
            $name2 = "Student2";
            $id2 = 2;
            $test_student = new Student($name, $id);
            $test_student->save();
            $test_student2 = new Student($name2, $id2);
            $test_student2->save();

            //Act
            $result = Student::getAll();
            var_dump($result);


            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Student1";
            $id = 1;
            $test_student = new Student($name, $id);
            $test_student->save();

            $name2 = "Student2";
            $id2 = 2;
            $test_student2 = new Student($name, $id);
            $test_student2->save();

            //Act
            Student::deleteAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Student1";
            $id = 1;
            $test_student = new Student($name, $id);
            $test_student->save();

            $name2 = "Student2";
            $id2 = 2;
            $test_student2 = new Student($name2, $id2);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);


        }


    }
?>
