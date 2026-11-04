# Pets

Session-only companion pets for Axolotl-PM API 5, authored by NhanAZ and licensed under MIT

[![CI](https://github.com/NhanAZ-Plugins/Pets/actions/workflows/build.yml/badge.svg)](https://github.com/NhanAZ-Plugins/Pets/actions/workflows/build.yml)
[![Latest release](https://img.shields.io/github/v/release/NhanAZ-Plugins/Pets)](https://github.com/NhanAZ-Plugins/Pets/releases/latest)
[![License](https://img.shields.io/github/license/NhanAZ-Plugins/Pets)](https://github.com/NhanAZ-Plugins/Pets/blob/main/LICENSE)
[![Discord](https://img.shields.io/discord/986553214889517088?label=Discord&logo=discord&logoColor=white&color=5865F2)](https://discord.gg/j2X83ujT6c)

## Overview

This plugin targets the PocketMine-MP and Axolotl-PM API 5 ecosystem and is maintained under [NhanAZ-Plugins](https://github.com/NhanAZ-Plugins).

Pets lets an operator summon a companion model by using `/pets type <bat|cat|chicken|dog|irongolem|pig|rabbit|snowgolem|spider|wolf|zombie>`. Use `/pets name <name>` to set its visible name, `/pets off` to dismiss it and clear the saved selection, or `/pets info` for attribution. Pet size changes remain unavailable.

Pets is authored and maintained by NhanAZ. Historical `type` values such as `BatPet` and the `name` key continue to load from the plugin's `players/<lowercase-player-name>.yml` data files. The two committed YAML snapshots in this source repository remain unchanged and are not copied into a server's plugin data folder.

The selected pet type and name persist in the plugin data folder. Live companion entities are not saved into world chunks; the pet is removed when its owner disconnects and restored from player data at the next join. Pets follow their owner and move to the owner's current world when necessary.

The manifest declares Axolotl-PM API 5.0.0 as the minimum API. PHPStan and PHAR builds use pinned API 5.0.0 and 5.49.1 source revisions; an API autoloader fixture validates all ten entity classes and network type IDs, and the isolated server startup check uses Axolotl-PM 5.49.1. These checks do not verify the mob models or movement with a connected game client.

The build workflow uses [DevTools](https://github.com/NhanAZ/DevTools) to analyze the plugin, build its PHAR and verify the artifact. The source is distributed under the [MIT License](LICENSE).
