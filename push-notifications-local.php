<?php
/*
Plugin Name: Responsive Centered Notification
Description: Notification centrée au milieu de l'écran avec un design responsive.
Version: 1.8.6
Author: Votre Nom
*/

function push_notifications_responsive_bar() {
    ?>
    <div id="responsive-notification-bar" style="display: none;">
        <span class="notification-title">Recevez nos notifications!</span>
        <button id="enable-notifications" class="notification-button">Activer</button>
        <button id="close-notification-bar" class="notification-close">&times;</button>
    </div>
    <div id="thank-you-message" style="display: none; text-align: center; padding: 10px; background-color: #ffffff; color: #000000; border: 1px solid #000000; border-radius: 10px; box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3); position: fixed; top: 20px; right: 20px; z-index: 1000; width: 250px; text-align: center;">
        Merci pour votre abonnement !
    </div>

    <style>
        /* Styles principaux */
        #responsive-notification-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffffff;
            color: #000000;
            border: 1px solid #000000;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 250px;
            height: auto;
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .notification-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .notification-button {
            margin-top: 15px;
            padding: 8px 15px;
            background-color: #0073aa;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            font-size: 14px;
        }

        .notification-close {
            position: absolute;
            top: 5px;
            right: 5px;
            background: none;
            color: #000000;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            #responsive-notification-bar {
                width: 80%;
                height: auto;
                padding: 15px;
                border-radius: 10px;
            }

            .notification-title {
                font-size: 14px;
            }

            .notification-button {
                font-size: 12px;
                padding: 10px 15px;
            }

            .notification-close {
                font-size: 16px;
            }
        }

        /* Style pour le message de remerciement */
        #thank-you-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #ffffff;
            color: #000000;
            border: 1px solid #000000;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            width: 250px;
            height: auto;
            padding: 10px 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
    <?php
}
add_action('wp_footer', 'push_notifications_responsive_bar');

// Ajouter le meta tag viewport dans le head
function push_notifications_add_meta_viewport() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
}
add_action('wp_head', 'push_notifications_add_meta_viewport');

// Ajouter le script pour gérer la notification et sa persistance
function push_notifications_responsive_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const notificationBar = document.getElementById('responsive-notification-bar');
        const enableNotificationsButton = document.getElementById('enable-notifications');
        const closeButton = document.getElementById('close-notification-bar');
        const thankYouMessage = document.getElementById('thank-you-message');

        // Vérifier immédiatement si la notification a été fermée dans localStorage
        const notificationState = localStorage.getItem('notificationDismissed');
        if (notificationState === 'true') {
            notificationBar.style.display = 'none'; // Masquer la notification si elle a été fermée
        } else {
            notificationBar.style.display = 'flex'; // Sinon, l'afficher
        }

        // Fermer la notification
        closeButton.addEventListener('click', function () {
            notificationBar.style.display = 'none';
            localStorage.setItem('notificationDismissed', 'true'); // Enregistrer l'état
        });

        // Activer les notifications
        enableNotificationsButton.addEventListener('click', function () {
            if (!('Notification' in window)) {
                alert("Votre navigateur ne supporte pas les notifications.");
                return;
            }

            Notification.requestPermission().then(function (permission) {
                if (permission === 'granted') {
                    new Notification("Merci pour votre abonnement !", {
                        body: "Vous recevrez toutes nos mises à jour ici.",
                        icon: "https://via.placeholder.com/128" //
                    });
                    notificationBar.style.display = 'none';
                    localStorage.setItem('notificationDismissed', 'true'); // Enregistrer l'état

                    // Afficher le message de remerciement avec le même style
                    thankYouMessage.textContent = "Merci pour votre abonnement !";
                    thankYouMessage.style.display = 'flex';

                    // Masquer le message après 5 secondes
                    setTimeout(function () {
                        thankYouMessage.style.display = 'none';
                    }, 5000);
                } else {
                    alert("Veuillez autoriser les notifications pour recevoir nos mises à jour.");
                }
            });
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'push_notifications_responsive_script');
?>
