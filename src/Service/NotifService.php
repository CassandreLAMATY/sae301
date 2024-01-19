<?php
// -------------------------- NOTIFICATIONS --------------------------//
namespace App\Service;

class NotifService {
    public function getUserNotifications($user, $notifUserRepository) {
        // Selecting every notification id by user id
        $notifications = $notifUserRepository->findByUserID($user->getUsrId());
        $notifSeen = [];
        $notifNotSeen = [];

        // Creating an array with every notification id
        $shouldNotify = false;
        foreach ($notifications as $notif) {
            if ($notif->isNuSeen() == false) {
                $shouldNotify = true;
            }
            if($notif->isNuSeen()) {
                $notifSeen[] = $notif;
            } else {
                $notifNotSeen[] = $notif;
            }
        }

        return [
            'notifSeen' => $notifSeen,
            'notifNotSeen' => $notifNotSeen,
            'shouldNotify' => $shouldNotify
        ];
    }
}

// ----------------------- END NOTIFICATIONS ------------------------ //
?>