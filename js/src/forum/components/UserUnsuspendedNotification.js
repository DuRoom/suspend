import app from 'duroom/forum/app';
import Notification from 'duroom/components/Notification';

export default class UserUnsuspendedNotification extends Notification {
  icon() {
    return 'fas fa-ban';
  }

  href() {
    return app.route.user(this.attrs.notification.subject());
  }

  content() {
    const notification = this.attrs.notification;

    return app.translator.trans('duroom-suspend.forum.notifications.user_unsuspended_text');
  }
}
