<?php


class StatementSheet
{
    const SUBJECTS_FILE = 'subjects';
    const STUDENTS_FILE = 'students';

    /**
     * @param string $filename
     * @return array|false
     * Загружаем данные из файла
     */
    public function getFileData(string $filename) {
        return file_exists($filename) ? file($filename, FILE_IGNORE_NEW_LINES) : [];
    }

    /**
     * @param string $fio
     * @return array|false|string[]
     * Загружаем оценки из файла студента
     */
    private function loadGrades(string $fio) {
        if (!file_exists($fio)) {
            return [];
        }

        $data = $this->getFileData($fio);
        $heads = explode(';', trim($data[0]));
        $grades = explode(';', trim($data[1]));

        return array_combine($heads, $grades);
    }

    /**
     * @param string $fio
     * @param array $grades
     * @return bool
     * Сохраняем новые оценки студента
     */
    private function saveGrades(string $fio, array $grades) {
        $data = implode(';', array_keys($grades)) . PHP_EOL;
        $data .= implode(';', $grades);

        return file_put_contents($fio, $data) && $this->saveStudent($fio) && $this->saveSubjects($grades);
    }

    /**
     * @param string $fio
     * @return false|int
     * Добавляем нового студента в список студентов
     */
    private function saveStudent(string $fio) {
        $students = $this->getFileData(self::STUDENTS_FILE);

        array_push($students, trim($fio));
        $newStudents = implode(PHP_EOL, array_filter(array_unique($students), 'strlen'));

        return file_put_contents(self::STUDENTS_FILE, trim($newStudents));
    }

    /**
     * @param array $grades
     * @return false|int
     * * Добавляем новый паредмет в список предметов
     */
    private function saveSubjects(array $grades) {
        $subjects = $this->getFileData(self::SUBJECTS_FILE);

        $newSubjects = array_merge($subjects, array_keys($grades));
        $newSubjects = implode(PHP_EOL, array_filter(array_unique($newSubjects), 'strlen'));

        return file_put_contents(self::SUBJECTS_FILE, trim($newSubjects));
    }

    /*****************************************************************************************************************/
    /**
     * @param string $fio
     * @param array $grades
     * @return bool
     * Запись оценок студента (заполнение ведомости)
     */
    public function setGrades(string $fio, array $grades) {
        $newGrades = array_merge($this->loadGrades($fio), $grades);

        return $this->saveGrades($fio, $newGrades);
    }

    /**
     * вывод ведомости в виде таблицы,
     * первый столбец содержит фио,
     * первая строка содержит названия предметов
     * если $students пуст, то выводим полную ведомость
     * @param array $students
     * @return string
     */
    public function printTable(array $students = []) {
        $subjects = $this->getFileData(self::SUBJECTS_FILE);
        if (empty($students)) {
            $students = $this->getFileData(self::STUDENTS_FILE);
        }

        $tab = ';';
        $table = 'Студент'.$tab.implode($tab, $subjects).PHP_EOL;
        foreach ($students as $student) {
            $grades = $this->loadGrades($student);
            $table .= $student.$tab;
            foreach ($subjects as $subject) {
                $table .= ($grades[$subject] ?? '').$tab;
            }
            $table .= PHP_EOL;
        }

        return $table;
    }

    /**
     * метод для вывода списка студентов-отличников
     */
    public function getPerfectStudents() {
        $result = [];
        $students = $this->getFileData(self::STUDENTS_FILE);
        foreach ($students as $student) {
            $grades = $this->loadGrades($student);
            if ((array_sum($grades) / 5) == count($grades)) {
                $result[] = $student;
            }
        }

        return empty($result) ? '' : $this->printTable($result);
    }

    /**
     * @return string
     * метод для вывода списка студентов,
     * которые имеют только одну тройку по любому предмету
     */
    public function getMiddleStudents() {
        $result = [];
        $students = $this->getFileData(self::STUDENTS_FILE);
        foreach ($students as $student) {
            $grades = $this->loadGrades($student);
            // в тз не совсем точно указано условие для этого метода
            // мб имелось в виду, что остальные оценки больше 3?
            // тогда условие будет выглядеть так:
//            if (
//                (count(array_keys($grades, 3)) == 1)
//                && (array_sum($grades) > (count($grades)*4 - 2))
//            ) {
            if (count(array_keys($grades, 3)) == 1) {
                $result[] = $student;
            }
        }

        return empty($result) ? '' : $this->printTable($result);
    }

    /**
     * @return string
     * метод для вывода списка студентов,
     * у которых есть более одной двойки
     */
    public function getBadStudents() {
        $result = [];
        $students = $this->getFileData(self::STUDENTS_FILE);
        foreach ($students as $student) {
            $grades = $this->loadGrades($student);
            if (count(array_keys($grades, 2)) > 1) {
                $result[] = $student;
            }
        }

        return empty($result) ? '' : $this->printTable($result);
    }
}