# Pets

Pets is a historical PocketMine-MP plugin for summoning companion entities. The manifest credits NameLess and records a Vietnamese edit and translation by Ghast Noob.

## Compatibility and data safety

The manifest declares PocketMine-MP API 1, 2 and early 3 versions. The source uses old entity registration, packets, levels and NBT APIs. It has not been ported or tested on Axolotl-PM 5. Do not install it on a current server or copy its data into an active player environment.

The plugin saves each player's chosen pet type in YAML. This repository already contains two historical files under `players/`; preserve them as repository data and do not treat them as test fixtures for a new deployment. A port needs a data migration plan, entity lifecycle tests and a disposable server before real player use.

There is no LICENSE file, CI workflow, DevTools PHAR, Axolotl-PM 5 runtime test or verified current release. Preserve the original and translation credits, and resolve redistribution rights before publishing a modified build.

For questions about the NhanAZ ecosystem, use [NhanAZ Discord](https://discord.gg/j2X83ujT6c).
