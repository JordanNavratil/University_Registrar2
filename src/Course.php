<?php
    class Course
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (name) VALUES ('{$this->getName()}');");
           $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $name = $course['name'];
                $id = $course['id'];
                $new_course = new Course($name, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT student_id FROM courses_students WHERE course_id = {$this->getId()};");
            $student_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $students = array();
            foreach($student_ids as $id) {
                $student_id = $id['student_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$student_id};");
                $returned_student = $result->fetchAll(PDO::FETCH_ASSOC);

                $description = $returned_student[0]['description'];
                $id = $returned_student[0]['id'];
                $new_student = new Student($student_name, $id, $date, $course_id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM courses_students WHERE course_id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }
    }

?>
