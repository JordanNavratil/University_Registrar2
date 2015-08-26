<?php

    class Student
    {

        private $student_name;
        private $id;
        private $date;
        private $course_id;

        function __construct($student_name, $id = null, $date, $course_id)
        {
            $this->student_name = $student_name;
            $this->id = $id;
            $this->date = $date;
            $this->course_id = $course_id;
        }

        function setStudentName($new_student_name)
        {
            $this->student_name = (string) $new_student_name;
        }

        function getStudentName()
        {
            return $this->student_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setDate($date) {
            $this->date = $new_date;
        }

        function getDate() {
            return $this->date;
        }

        function getCourseId(){
            return $this->course_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (student_name, date, course_id) VALUES ('{$this->getStudentName()}', '{$this->getDate()}', {$this->getCourseId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_student_name)
        {
            $GLOBALS['DB']->exec("UPDATE students SET student_name = '{$new_student_name}' WHERE id = {$this->getId()};");
            $this->setStudentName($new_student_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getID()};");
            $GLOBALS['DB']->exec("DELETE FROM courses_students WHERE student_id = {$this->getId()};");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$course->getId()}, {$this->getId()});");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT course_id FROM courses_students WHERE student_id = {$this->getId()};");
            $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);
            $courses = array();
            foreach($course_ids as $id) {
                $course_id = $id['course_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$course_id};");
                $returned_course = $result->fetchAll(PDO::FETCH_ASSOC);
                $name = $returned_course[0]['name'];
                $id = $returned_course[0]['id'];
                $new_course = new course($name, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student){
                $student_name = $student['student_name'];
                $id = $student['id'];
                $date = $student['date'];
                $course_id = $student['course_id'];
                $new_student = new Student($student_name, $id, $date, $course_id);
                array_push($students, $new_student);
            }
            return $students;

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students;");

        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

    }
?>
