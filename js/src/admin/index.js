import app from 'duroom/app';

app.initializers.add('duroom-suspend', () => {
  app.extensionData.for('duroom-suspend').registerPermission(
    {
      icon: 'fas fa-ban',
      label: app.translator.trans('duroom-suspend.admin.permissions.suspend_users_label'),
      permission: 'user.suspend',
    },
    'moderate'
  );
});
