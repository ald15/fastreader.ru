let   avatarName = '',
lastChoose = '';

function chooseAvatar(n) {
  avatarId = n;
  clearLastAvatarChoose();
  avatarName = 'avatar_' + avatarId;
  lastChoose = avatarName;
  document.getElementById(avatarName).style = 'border-color: #e04a00; box-shadow: rgba(224, 74, 0, 0.5) 0px 0px 0.5rem 0.4rem;';
  document.getElementById('userAvatarId').value = avatarId;
}

function clearLastAvatarChoose() {
  if (lastChoose != '') {
    document.getElementById(lastChoose).style = '';
  }
}
