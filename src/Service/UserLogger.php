<?php
namespace App\Service;

use App\Entity\User;
use App\Entity\UserLog;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class UserLogger
{
    public static function log($message): void
    {
        try {
            if (is_object($message)) {
                if (method_exists($message, '__toString')) {
                    $message = (string) $message;
                } elseif (method_exists($message, 'getId')) {
                    $message = 'Object of class ' . get_class($message) . ' with ID: ' . $message->getId();
                } else {
                    $message = 'Object of class ' . get_class($message);
                }
            }

            $timestamp = date('Y-m-d H:i:s') . " - " . $message . PHP_EOL;

            @file_put_contents('user.log', $timestamp, FILE_APPEND);
            @file_put_contents('service_log.log', $timestamp, FILE_APPEND);
        } catch (\Throwable $e) {
            // silently fail
        }
    }

    public static function logToDatabase(User $user, string $action, string $target, ManagerRegistry $doctrine, LoggerInterface $logger): void
    {
        try {
            $log = new UserLog();
            $log->setAction($action);
            $log->setPerformedBy($user->getUserIdentifier());
            $log->setUserEmail($user->getEmail());
            $log->setObjectName($target);
            $log->setCreatedAt(new \DateTime());

            $em = $doctrine->getManager(); // unified DB
            $em->persist($log);
            $em->flush();

            $logger->info('User log saved', [
                'user' => $user->getEmail(),
                'action' => $action,
                'target' => $target
            ]);
        } catch (\Throwable $e) {
            $logger->error('Failed to log to database', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
