
namespace app.components {
  export interface ITrack {
    title: string;
    artist: string;
    prevLyrics: string;
    soundCloudId?: string;
    albumThumbnail?: string;
    soundCloudPermalink?: string;
  }
}
