<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\SendStacksOfEmails;

class SendStacksOfEmailsCommand extends Command
{



    private $manager;
    private $sendStacks;

    public function __construct(EntityManagerInterface $manager, SendStacksOfEmails $sendStacks)
    {
        $this->manager = $manager;
        $this->sendStacks = $sendStacks;
        parent::__construct();
    }

    protected function configure()
    {

        // the name of the command (the part after "bin/console")
        $this->setName('app:send-emails-open')
            // the short description shown while running "php bin/console list"
            ->setDescription('Send stacks of emails .');
    }
    
    /** @var \Symfony\Component\Console\Output\OutputInterface $output */
    private $output;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = microtime(true);
        $this->output = $output;
        try {
            $response = $this->searchEmailsExpired();
            $this->output->writeln($response["message"] . ' // ' . (microtime(true) - $start) . ' segundos.');
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Search emails expired and remove
     * @return bollean  status
     */
    private function searchEmailsExpired()
    {
        try {

            $emailsPass = $this->manager->getRepository('App:EmailSpool')
                ->checkEmailSpoolsMinus90Days($this->subIntervalDays());
            if (count($emailsPass) > 0) {
                $this->removeEmailsMinus90Days($emailsPass);
            }
            $emailsSend = $this->manager->getRepository('App:EmailSpool')->getEmailSpools();
            $message = "No hay correos para enviar en la pila";
            if (count($emailsSend) > 0) {
                $rest = $this->sendEmails($emailsSend);
                if ($rest["status"] == true) {
                    $rest["count_error"] . " error";
                    $sendTotal = count($emailsSend) - $rest["count_error"];
                    $message = "Correos enviados con éxito: " . $sendTotal . " de " . count($emailsSend) . " correos";
                }
            }
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
            $message = $ex->getMessage();
        }
        echo "\n";
        return ["message" => $message, "status" => $status];
    }

    /**
     * @param date $emails
     * delete emails past 90 days
     */
    private function removeEmailsMinus90Days($emails)
    {
        try {

            foreach ($emails as $email) {
                $this->manager->remove($email);
            }
            $this->manager->flush();
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
        }

        return $status;
    }

    /**
     * @param date $emails
     * send emails stacks
     */
    private function sendEmails($emails)
    {
        try {
            $rest = $this->sendStacks->sendEmailStacks($emails);
            $rest['status'] = true;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            $rest['status'] = false;
        }

        return $rest;
    }

    /**
     *
     * subtract 90 days from current date
     */
    private function subIntervalDays()
    {
        $today = new \DateTime('now');
        $interval = new \DateInterval('P90D');
        $today->sub($interval);

        return $today;
    }
}
