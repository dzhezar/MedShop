<?php


namespace App\Command;


use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncStatesCommand extends Command
{
    protected static $defaultName = 'app:sync-states';
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $project_dir;

    /**
     * SyncStates constructor.
     * @param $project_dir
     * @param EntityManagerInterface $entityManager
     */
    public function __construct($project_dir, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->project_dir = $project_dir;
    }

    protected function configure()
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = \json_decode(file_get_contents($this->project_dir.'/states.json'), true);

        foreach ($this->entityManager->getRepository(State::class)->findAll() as $item) {
            $this->entityManager->remove($item);
        }


        foreach ($data as $code => $name) {
            $this->entityManager->persist((new State())->setCode($code)->setName($name));
        }

        $this->entityManager->flush();

        return 0;
    }
}
