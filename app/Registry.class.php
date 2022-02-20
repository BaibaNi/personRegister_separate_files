<?php


class Registry extends Database
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function registerPerson(Person $person): string
    {
        if (empty($person->getName())) {
            $message = 'Unable to register this person. Name is required.';
        } elseif (empty($person->getSurname())) {
            $message = 'Unable to register this person. Surname is required.';
        } elseif (empty($person->getCode())) {
            $message = 'Unable to register this person. Personal ID code is required.';
        } elseif (!$this->checkIfCodeUnique($person->getCode())) {
            $message = 'Unable to register. Person with such Personal ID code already exists in the Database.';
        } else {
            $this->registration($person->getName(), $person->getSurname(), $person->getCode());
            $message = "Registration successful!";
        }

        return $message;

    }


    /**
     * @throws \Doctrine\DBAL\Exception
     */
    private function checkIfCodeUnique(string $code): bool
    {
        $status = '';
        foreach ($this->getDatabaseRecords() as $data) {
            if ($code !== $data['code']) {
                $status = true;
            } else {
                $status = false;
            }
        }
        return $status;
    }



    public function registration(string $name, string $surname, string $code): void
    {

        $registry = [
            'name' => $name,
            'surname' => $surname,
            'code' => $code
        ];

        try {
            $this->connect()->insert('person_register.persons', $registry);
        } catch (\Doctrine\DBAL\Exception $e) {
            echo 'Error! ' . $e->getMessage() . PHP_EOL;
            die();
        }

    }


    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getDatabaseRecords(): Traversable
    {
        return $this->connect()->iterateAssociativeIndexed(
            'SELECT id, name, surname, code FROM person_register.persons');
    }

}
